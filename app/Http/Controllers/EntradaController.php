<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Ingreso;
use Illuminate\Http\Request;

class EntradaController extends Controller{

    public function registrarEntrada(Request $request){

        // Validamos que venga el dato
        $request->validate([
            'codigo' => 'required'
        ]);

        // Validamos que el codigo exista en la base de datos
        $estudiante = Estudiante::where('codigo_tarjeta', $request->codigo)->first();

        if(!$estudiante){
            return response()->json([
                'success' => false,
                'message' => 'No users found with the specified code',
                'data' => null,
                'errors' => null
            ], 404);
        }

        // Creamos una nueva entrada
        $ingreso = new Ingreso;
        $ingreso->estudianteId = $estudiante->id;
        $ingreso->codigo_tarjeta = $request->codigo;
        $ingreso->fecha_ingreso = date('Y-m-d H:i:s');
        $ingreso->save();

        return response()->json([
            'success' => true,
            'message' => 'Entrada registrada correctamente',
            'data' => null,
            'errors' => null
        ], 200);
    }
}