<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller{

    public function index(){

        $roles = ['Administrador', 'Acudiente'];

        return view('secciones.usuario', compact('roles'));
    }

    public function search(Request $request){

        // Inicia una consulta en el modelo Ingreso
        $query = User::query();

        // Filtra por email del user
        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        // Filtra por nombre del User
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Ejecuta la consulta y obtiene los resultados
        $results = $query->orderBy('name', 'asc')->paginate(20); // Paginar los resultados

        // Devuelve los resultados a la vista
        return view('secciones.usuario', compact('results'));

    }

    public function create(){
        $roles = ['Administrador', 'Acudiente'];
        $user = new User;
        return view('secciones.formUsuario', compact('user', 'roles'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:Administrador,Estudiante,Acudiente']
        ],[
            'role.required' => 'El campo rol es obligatorio.',
            'role.in' => 'El campo rol es inválido.'
        ]);

        // Creo el estudiante
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        // return redirect()->route('user.index')->with('success', 'Estudiante creado con éxito');
        return redirect()->route('user.edit', $user->id)->with('success', 'Usuario creado con éxito');
    }

    public function edit($id){
        $roles = ['Administrador', 'Acudiente'];

        $user = User::findOrFail($id);

        return view('secciones.formUsuario', compact('user', 'roles'));
    }

    public function update(Request $request, $id){

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => ['required', 'in:Administrador,Estudiante,Acudiente']
        ],[
            'role.required' => 'El campo rol es obligatorio.',
            'role.in' => 'El campo rol es inválido.'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        // return redirect()->route('students.index')->with('success', 'Estudiante actualizado con éxito');
        return redirect()->route('user.edit', $user->id)->with('success', 'Usuario actualizado con éxito');
    }

    public function delete($id){

        // Buscamos el estudiante
        $user = User::findOrFail($id);

        // Valido si es un estudiante
        if($user->role === 'Estudiante'){
            // Voy a dejar el estudiante que tenga ese id en null
            $estudiantes = Estudiante::where('user_id', $id)->update(['user_id' => null]);
        }

        // Eliminamos el estudiante
        $user->delete();
        
        return redirect()->route('user.search')->with('deleted', 'Usuario eliminado con éxito');
    }

}