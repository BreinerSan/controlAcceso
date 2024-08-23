@extends('layouts.admin')

@section('tituloSeccion', 'Ingresos de estudiantes')

@section('content')

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
                <form action="{{ route('search') }}" method="GET">
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

                        <!-- Campo de fecha para Fecha específica -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="specific_date">Fecha específica</label>
                                <input type="date" name="specific_date" id="specific_date" class="form-control" value="{{ old('specific_date', request('specific_date')) }}"> 
                            </div>
                        </div>                
                
                        <!-- Campo de texto para Nombre -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese nombre" value="{{ old('name', request('name')) }}">
                            </div>
                        </div>

                        <!-- Campo de texto para codigo tarjeta -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cardCode">Codigo de tarjeta</label>
                                <input type="text" name="cardCode" id="cardCode" class="form-control" placeholder="Ingrese codigo de tarjeta" value="{{ old('cardCode', request('cardCode')) }}">
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
                                    <th>Codigo tarjeta</th>
                                    <th>Fecha de Ingreso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $ingreso)
                                    <tr>
                                        <td>{{ $ingreso->estudiante->nombre }}</td>
                                        <td>{{ $ingreso->estudiante->grado }}</td>
                                        <td>{{ $ingreso->codigo_tarjeta }}</td>
                                        <td>{{ $ingreso->created_at->format('d/m/Y H:i:s') }}</td>
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
    <script src="{{ asset('js/ingresos/index.js') }}"></script>
@endsection