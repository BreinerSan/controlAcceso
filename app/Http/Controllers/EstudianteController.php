<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller{

    public function index(){

        $grades = [
            'Programación de software 10',
            'Programación de software 11',
            'Sistemas 10',
            'Sistemas 11',
            'Ebanisteria 10',
            'Ebanisteria 11',
            'Mecánica 10',
            'Mecánica 11',
            'Dibujo arquitectónico 10',
            'Dibujo arquitectónico 11'
        ];

        return view('secciones.estudiante', compact('grades'));
    }

    public function search(Request $request){

        // Inicia una consulta en el modelo Ingreso
        $query = Estudiante::query();

        // Filtra por grado del estudiante
        if ($request->filled('grade')) {
            $query->where('grado', $request->input('grade'));
        }

        // Filtra por documento del estudiante
        if ($request->filled('document')) {
            $query->where('documento', $request->input('document'));
        }

        // Filtra por nombre del estudiante
        if ($request->filled('name')) {
            $query->where('nombre', 'like', '%' . $request->input('name') . '%');
        }

        // Filtra por tarjeta id del estudiante
        if ($request->filled('cardId')) {
            $query->where('codigo_tarjeta', $request->input('cardId'));
        }

        // Ejecuta la consulta y obtiene los resultados
        $results = $query->orderBy('nombre', 'asc')->paginate(20); // Paginar los resultados

        $grades = [
            'Programación de software 10',
            'Programación de software 11',
            'Sistemas 10',
            'Sistemas 11',
            'Ebanisteria 10',
            'Ebanisteria 11',
            'Mecánica 10',
            'Mecánica 11',
            'Dibujo arquitectónico 10',
            'Dibujo arquitectónico 11'
        ];

        // Devuelve los resultados a la vista
        return view('secciones.estudiante', compact('results', 'grades'));

    }

    public function create(){
        $grades = [
            'Programación de software 10',
            'Programación de software 11',
            'Sistemas 10',
            'Sistemas 11',
            'Ebanisteria 10',
            'Ebanisteria 11',
            'Mecánica 10',
            'Mecánica 11',
            'Dibujo arquitectónico 10',
            'Dibujo arquitectónico 11'
        ];
        $student = new Estudiante;
        return view('secciones.formEstudiante', compact('grades', 'student'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|numeric|unique:estudiante,documento',
            'email' => 'required|string|email|max:255|unique:estudiante,correo_electronico',
        ],[
            'name.required' => 'El nombre es obligatorio.',
            'document.required' => 'El nombre es obligatorio.',
            'document.unique' => 'Este documento ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
        ]);

        // Creo el estudiante
        $estudiante = new Estudiante;
        $estudiante->nombre = $request->name;
        $estudiante->documento = $request->document;
        $estudiante->grado = $request->grade;
        $estudiante->codigo_tarjeta = $request->cardCode;
        $estudiante->correo_electronico = $request->email;
        $estudiante->save();

        // Valido si esta activo la opcion de crear acceso
        if(isset($request->generateAccess) && $request->generateAccess == 1){

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'Estudiante';
            $user->password = Hash::make($request->document);
            $user->save();

            // vinculo el usuario creado al estudiante
            $estudiante->user_id = $user->id;
            $estudiante->save();

        }

        // return redirect()->route('students.index')->with('success', 'Estudiante creado con éxito');
        return redirect()->route('students.edit', $estudiante->id)->with('success', 'Estudiante creado con éxito');
    }

    public function edit($id){
        $grades = [
            'Programación de software 10',
            'Programación de software 11',
            'Sistemas 10',
            'Sistemas 11',
            'Ebanisteria 10',
            'Ebanisteria 11',
            'Mecánica 10',
            'Mecánica 11',
            'Dibujo arquitectónico 10',
            'Dibujo arquitectónico 11'
        ];
        $student = Estudiante::findOrFail($id);

        return view('secciones.formEstudiante', compact('grades', 'student'));
    }

    public function update(Request $request, $id){

        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|numeric|unique:estudiante,documento,'.$estudiante->id,
            'email' => 'required|string|email|max:255|unique:estudiante,correo_electronico,'.$estudiante->id,
        ],[
            'name.required' => 'El nombre es obligatorio.',
            'document.required' => 'El nombre es obligatorio.',
            'document.unique' => 'Este documento ya está registrado.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
        ]);

        $estudiante->nombre = $request->name;
        $estudiante->documento = $request->document;
        $estudiante->grado = $request->grade;
        $estudiante->codigo_tarjeta = $request->cardCode;
        $estudiante->correo_electronico = $request->email;
        $estudiante->save();

        // Valido si esta activo la opcion de crear acceso
        if(isset($request->generateAccess) && $request->generateAccess == 1){

            if(is_null($estudiante->user_id)){
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role = 'Estudiante';
                $user->password = Hash::make($request->document);
                $user->save();
    
                // vinculo el usuario creado al estudiante
                $estudiante->user_id = $user->id;
                $estudiante->save();
            }
            
        }

        // return redirect()->route('students.index')->with('success', 'Estudiante actualizado con éxito');
        return redirect()->route('students.edit', $estudiante->id)->with('success', 'Estudiante actualizado con éxito');
    }

    public function delete($id){

        // Buscamos el estudiante
        $student = Estudiante::findOrFail($id);

        // Validamos si tiene un registro en users
        if(!is_null($student->user_id)){
            $user = User::find($student->user_id);
            if($user){
                $user->delete();
            }
        }

        // Eliminamos el estudiante
        $student->delete();
        
        return redirect()->route('searchStudent')->with('deleted', 'Estudiante eliminado con éxito');
    }

}