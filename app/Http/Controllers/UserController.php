<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar =='')
        {
            $users = User::join('personas','users.id','=','personas.id')
                                ->join('roles','users.idrol','roles.id')
                                ->select('personas.id',
                                            'personas.nombre',
                                            'personas.tipo_documento',
                                            'personas.num_documento',
                                            'personas.direccion',
                                            'personas.telefono',
                                            'personas.email',
                                            'users.usuario',
                                            'users.password',
                                            'users.condicion',
                                            'users.idrol',
                                            'roles.nombre as rol')
                                ->orderBy('personas.id','desc')->paginate(3);
        } 
        else
        {
            $users = User::join('personas','users.id','=','personas.id')
                                ->join('roles','users.idrol','roles.id')
                                ->select('personas.id',
                                                'personas.nombre',
                                                'personas.tipo_documento',
                                                'personas.num_documento',
                                                'personas.direccion',
                                                'personas.telefono',
                                                'personas.email',
                                                'users.usuario',
                                                'users.password',
                                                'users.condicion',
                                                'users.idrol',
                                                'roles.nombre as rol')
                                    ->where('personas.'.$criterio,'like','%'. $buscar . '%')->orderBy('personas. id','desc')->paginate(3);
        }

        return [

            'pagination' => 
            [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'usuarios' => $users
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

            $users = new User();
            $users->usuario = $request->usuario;
            $users->password = bcrypt($request->password);
            $users->condicion = '1';
            $users->idrol = $request->idrol;


            $users->id = $persona->id;

            $users->save();

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

            $user =  User::findOrFail($request->id);
            $persona = Persona::findOrFail($user->id);

            
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $users->usuario = $request->usuario;
            $users->password = bcrypt($request->password);
            $users->condicion = '1';
            $users->idrol = $request->idrol;

            $user->save();

            DB::commit();

        } catch (Exception $th) {
            
            DB::rollBack();

        }

    }

    public function desactivate(Request $request)
    {

        if(!$request->ajax()) return redirect('/');


        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
