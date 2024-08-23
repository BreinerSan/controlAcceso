@extends('layouts.admin')

@section('tituloSeccion', 'Estudiantes')

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
                    {{ isset($student->id) ? 'Actualizar' : 'Registrar' }}
                </div>
            </div>

            <form action="{{ isset($student->id) ? route('students.update', $student->id) : route('students.store') }}" method="POST">
                @csrf

                @if (isset($student->id))
                    @method('PUT')
                @endif
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="name">Nombre y Apellido (Obligatorio)</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre y Apellido" value="{{ old('name', $student->nombre) }}">
                    </div>
    
                    <div class="form-group">
                        <label for="document">Documento (Obligatorio)</label>
                        <input type="text" class="form-control" id="document" name="document" placeholder="Documento" value="{{ old('document', $student->documento) }}">
                    </div>
    
                    <div class="form-group">
                        <label for="grade">Grado</label>
                        <select name="grade" id="grade" class="form-control">
                            <option value="">Seleccione Grado</option>
                            <!-- Opciones de grado -->
                            @foreach($grades as $grade)
                                <option value="{{ $grade }}" {{ old('grade', $student->grado) == $grade ? 'selected' : '' }}>
                                    {{ $grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group">
                        <label for="email">Correo Electronico (Obligatorio)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico" value="{{ old('email', $student->correo_electronico) }}">
                    </div>
    
                    <div class="form-group">
                        <label for="cardCode">Codigo de tarjeta</label>
                        <input type="text" class="form-control" id="cardCode" name="cardCode" placeholder="Codigo de tarjeta" value="{{ old('cardCode', $student->codigo_tarjeta) }}">
                    </div>

                    @if(is_null($student->user_id))
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="generateAccess" id="generateAccess" value="1" {{ (!isset($student->id)) ? 'checked' : '' }}>
                            <label for="generateAccess" class="form-check-label">Generar acceso para este estudiante</label>
                            <p class="info">Al activar esta opción se creará un acceso al sistema para este estudiante donde las credenciales serán el correo y el numero de documento como contraseña</p>
                        </div>
                    </div>
                    @endif

                </div>
    
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ isset($student->id) ? 'Actualizar estudiante' : 'Crear estudiante' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection