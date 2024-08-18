<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;

class IngresoController extends Controller{

    public function index(){
        
        $grades = ['11-A', '11-B', '11-C'];

        return view('secciones.ingreso', compact('grades'));
    }

    public function search(Request $request){

        // Inicia una consulta en el modelo Ingreso
        $query = Ingreso::with('estudiante');

        // Filtra por grado del estudiante
        if ($request->filled('grade')) {
            $query->whereHas('estudiante', function ($query) use ($request) {
                $query->where('grado', $request->input('grade'));
            });
        }

        // Filtra por nombre del estudiante
        if ($request->filled('name')) {
            $query->whereHas('estudiante', function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->input('name') . '%');
            });
        }

        // Filtra por fecha específica
        if ($request->filled('specific_date')) {
            $query->whereDate('fecha_ingreso', $request->input('specific_date'));
        }

        // Ejecuta la consulta y obtiene los resultados
        $results = $query->orderBy('fecha_ingreso', 'desc')->paginate(20); // Paginar los resultados

        $grades = ['11-A', '11-B', '11-C'];

        // Devuelve los resultados a la vista
        return view('secciones.ingreso', compact('results', 'grades'));
    }

}