@extends('layouts.admin')

@section('tituloSeccion', 'Usuarios')

@section('content')

<div class="row">

    @if ($errors->any())
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <h5>
                    <i class="icon fas fa-exclamation-triangle"></i>
                </h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    {{ isset($user->id) ? 'Actualizar' : 'Registrar' }}
                </div>
            </div>

            <form action="{{ isset($user->id) ? route('user.update', $user->id) : route('user.store') }}" method="POST">
                @csrf

                @if (isset($user->id))
                    @method('PUT')
                @endif

                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="name">Nombre (Obligatorio)</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="role">Rol (Obligatorio)</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">Seleccione Rol</option>
                            <!-- Opciones de grado -->
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group">
                        <label for="email">Correo Electronico (Obligatorio)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico" value="{{ old('email', $user->email) }}">
                    </div>

                    @if (!isset($user->id))
                        <div class="form-group">
                            <label for="password">Contraseña (Obligatorio)</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Contraseña">
                        </div>
                    @endif
    
                </div>
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ isset($user->id) ? 'Actualizar usuario' : 'Crear usuario' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection