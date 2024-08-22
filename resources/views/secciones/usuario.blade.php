@extends('layouts.admin')

@section('tituloSeccion', 'Usuarios')

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="{{ url('usuarios/create') }}" class="btn btn-primary btn-block mb-3">
            <i class="fa fa-plus"></i>
            Registrar usuario
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
                <form action="{{ route('user.search') }}" method="GET">
                    <div class="row">   
                        
                        <!-- Campo de texto para Correo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese Correo" value="{{ old('email', request('email')) }}">
                            </div>
                        </div>
                
                        <!-- Campo de texto para Nombre -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Ingrese nombre" value="{{ old('name', request('name')) }}">
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
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                                                Editar
                                                <i class="fas fa-edit"></i>
                                            </a>
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

@endsection