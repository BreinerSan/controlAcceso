<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller{

    public function index(){

        $grades = ['11-A', '11-B', '11-C'];

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

        $grades = ['11-A', '11-B', '11-C'];

        // Devuelve los resultados a la vista
        return view('secciones.estudiante', compact('results', 'grades'));

    }

    public function create(){
        $grades = ['11-A', '11-B', '11-C'];
        $student = new Estudiante;
        return view('secciones.formEstudiante', compact('grades', 'student'));
    }

    public function store(Request $request){

        // Creo el estudiante
        $estudiante = new Estudiante;
        $estudiante->nombre = $request->name;
        $estudiante->documento = $request->document;
        $estudiante->grado = $request->grade;
        $estudiante->codigo_tarjeta = $request->cardCode;
        $estudiante->correo_electronico = $request->email;
        $estudiante->save();

        return redirect()->route('students.index')->with('success', 'Estudiante creado con éxito');
    }

    public function edit($id){
        $grades = ['11-A', '11-B', '11-C'];
        $student = Estudiante::findOrFail($id);

        return view('secciones.formEstudiante', compact('grades', 'student'));
    }

    public function update(Request $request, $id){

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->nombre = $request->name;
        $estudiante->documento = $request->document;
        $estudiante->grado = $request->grade;
        $estudiante->codigo_tarjeta = $request->cardCode;
        $estudiante->correo_electronico = $request->email;
        $estudiante->save();

        return redirect()->route('students.index')->with('success', 'Estudiante actualizado con éxito');
    }

}