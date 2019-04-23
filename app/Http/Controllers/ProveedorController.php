<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Proveedor;
use Illuminate\Support\Facades\DB;


class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar =='')
        {
            $proveedor = Proveedor::join('personas','proveedores.id','=','personas.id')
                                    ->select('personas.id',
                                             'personas.nombre',
                                             'personas.tipo_documento',
                                             'personas.num_documento',
                                             'personas.direccion',
                                             'personas.telefono',
                                             'personas.email',
                                             'proveedores.contacto',
                                             'proveedores.telefono_contacto')
                                    ->orderBy('personas.id','desc')->paginate(3);
        } 
        else
        {
            $proveedor = Proveedor::join('personas','proveedores.id','=','personas.id')
                                    ->select('personas.id',
                                            'personas.nombre',
                                            'personas.tipo_documento',
                                            'personas.num_documento',
                                            'personas.direccion',
                                            'personas.telefono',
                                            'personas.email',
                                            'proveedores.contacto',
                                            'proveedores.telefono_contacto')
                                    ->where('personas.'.$criterio,'like','%'. $buscar . '%')->orderBy('personas. id','desc')->paginate(3);
        }

        return [

            'pagination' => 
            [
                'total' => $proveedor->total(),
                'current_page' => $proveedor->currentPage(),
                'per_page' => $proveedor->perPage(),
                'last_page' => $proveedor->lastPage(),
                'from' => $proveedor->firstItem(),
                'to' => $proveedor->lastItem()
            ],
            'proveedores' => $proveedor
        ];
    }

 
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try {
            
            DB::beginTransaction();
            
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $proveedor = new Proveedor();
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->id = $persona->id;
            $proveedor->save();

            DB::commit();

        } catch (Exception $th) {
            
            DB::rollBack();

        }

       
    }

   
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();

            $proveedor = Proveedor::findOrFail($request->id);
            $persona = Persona::findOrFail($request->id);

            
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->id = $persona->id;
            $proveedor->save();

            DB::commit();

        } catch (Exception $th) {
            
            DB::rollBack();

        }

    }

}
