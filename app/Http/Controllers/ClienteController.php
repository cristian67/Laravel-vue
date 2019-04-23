<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar =='')
        {
            $persona = Persona::orderBy('id','desc')->paginate(3);
        }
        else
        {
            $persona = Persona::where($criterio,'like','%'. $buscar . '%')->orderBy('id','desc')->paginate(3);
        }

        return [

            'pagination' => 
            [
                'total' => $persona->total(),
                'current_page' => $persona->currentPage(),
                'per_page' => $persona->perPage(),
                'last_page' => $persona->lastPage(),
                'from' => $persona->firstItem(),
                'to' => $persona->lastItem()
            ],
            'personas' => $persona
        ];
    }

 
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $persona = new Persona();

        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        
        $persona->save();
    }

   
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();
    }

 
}
