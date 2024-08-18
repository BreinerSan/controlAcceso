@extends('layouts.admin')

@section('tituloSeccion', 'Estudiantes')

@section('content')

<div class="row">
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
                        <label for="name">Nombre y Apellido</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre y Apellido" value="{{ old('name', $student->nombre) }}">
                    </div>
    
                    <div class="form-group">
                        <label for="document">Documento</label>
                        <input type="text" class="form-control" id="document" name="document" placeholder="Documento" value="{{ old('name', $student->documento) }}">
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
                        <label for="email">Correo Electronico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electronico" value="{{ old('name', $student->correo_electronico) }}">
                    </div>
    
                    <div class="form-group">
                        <label for="cardCode">Codigo de tarjeta</label>
                        <input type="text" class="form-control" id="cardCode" name="cardCode" placeholder="Codigo de tarjeta" value="{{ old('name', $student->codigo_tarjeta) }}">
                    </div>
    
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