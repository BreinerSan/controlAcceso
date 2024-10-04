<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngresoController extends Controller{

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

        return view('secciones.ingreso', compact('grades'));
    }

    public function search(Request $request){

        // Inicia una consulta en el modelo Ingreso
        $query = Ingreso::with('estudiante');

        $query->whereHas('estudiante');

        // Si es estudiante solo debe mostrar lo de el 
        if(Auth::check() && Auth::user()->role === 'Estudiante'){
            $query->whereHas('estudiante', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });
        }

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

        // Filtra por codigo de tarjeta
        if ($request->filled('cardCode')) {
            $query->where('codigo_tarjeta', $request->input('cardCode'));
        }

        // Ejecuta la consulta y obtiene los resultados
        $results = $query->orderBy('fecha_ingreso', 'desc')->paginate(20); // Paginar los resultados

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
        return view('secciones.ingreso', compact('results', 'grades'));
    }

}