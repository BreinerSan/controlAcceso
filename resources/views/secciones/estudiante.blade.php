@extends('layouts.admin')

@section('tituloSeccion', 'Estudiantes')

@section('content')

@if(session('deleted'))
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {{ session('deleted') }}
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <a href="{{ url('estudiantes/create') }}" class="btn btn-primary btn-block mb-3">
            <i class="fa fa-plus"></i>
            Registrar Estudiante
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Búsqueda 
                </div>
            </div>
            <div class="card-body">
                {{-- Formulario de busqueda --}}
                <form action="{{ route('searchStudent') }}" method="GET">
                    <div class="row">
                        <!-- Select para Grado -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="grade">Grado</label>
                                <select name="grade" id="grade" class="form-control">
                                    <option value="">Seleccione Grado</option>
                                    <!-- Opciones de grado -->
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade }}" {{ old('grade', request('grade')) == $grade ? 'selected' : '' }}>
                                            {{ $grade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>      
                        
                        <!-- Campo de texto para Documento -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="document">Documento</label>
                                <input type="text" name="document" id="document" class="form-control" placeholder="Ingrese documento" value="{{ old('document', request('document')) }}">
                            </div>
                        </div>
                
                        <!-- Campo de texto para Nombre -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese nombre" value="{{ old('name', request('name')) }}">
                            </div>
                        </div>

                        <!-- Campo de texto para Codigo tarjeta -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cardId">Codigo tarjeta</label>
                                <input type="text" name="cardId" id="cardId" class="form-control" placeholder="Ingrese codigo tarjeta" value="{{ old('cardId', request('cardId')) }}">
                            </div>
                        </div>
                
                    </div>
                
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mostrar resultados de la búsqueda -->
        <div class="card mt-4">
            <div class="card-header">
                Resultados de la Búsqueda
            </div>
            <div class="card-body">
                @isset($results)
                    @if($results->isEmpty())
                        <p>No se encontraron resultados.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del Estudiante</th>
                                    <th>Grado</th>
                                    <th>Codigo tarjea</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $estudiante)
                                    <tr>
                                        <td>{{ $estudiante->nombre }}</td>
                                        <td>{{ $estudiante->grado }}</td>
                                        <td>{{ $estudiante->codigo_tarjeta }}</td>
                                        <td>
                                            <a href="{{ route('students.edit', $estudiante->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </a>
                                            <button class="btn btn-danger" onclick="confirmDelete({{$estudiante->id}})">
                                                <i class="fas fa-trash"></i>
                                                Eliminar
                                            </button>
                                            <form id="deleteStudentForm{{$estudiante->id}}" action="{{ route('students.delete', $estudiante->id) }}" method="POST" style="display:none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
        
                    @endif
                @else
                    <p>No se han realizado búsquedas.</p>
                @endisset
            </div>
            @isset($results)
                @if(!$results->isEmpty())
                    <div class="card-footer clearfix">
                        <div class="d-flex float-right">
                            {{ $results->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            @endisset
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    function confirmDelete(estudentId){
        if(confirm('Estas seguro de eliminar este estudiante? Esta acción no se puede deshacer.')){
            document.getElementById('deleteStudentForm'+estudentId).submit();
        }
    }

</script>

@endsection