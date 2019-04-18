<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategorieController extends Controller
{
  
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar=='')
        {
            $categorie = Categorie::orderBy('id','desc')->paginate(3);
        }
        else
        {
            $categorie = Categorie::where($criterio,'like','%'. $buscar . '%')->orderBy('id','desc')->paginate(3);
        }
        return [

            'pagination' => 
            [
                'total' => $categorie->total(),
                'current_page' => $categorie->currentPage(),
                'per_page' => $categorie->perPage(),
                'last_page' => $categorie->lastPage(),
                'from' => $categorie->firstItem(),
                'to' => $categorie->lastItem()
            ],
            'categorias' => $categorie
        ];
    }

 
    public function selectCategoria(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $categories = Categorie::where('condicion','=','1')
                                 ->select('id','nombre')
                                 ->orderBy('nombre','asc')
                                 ->get();

        return ['categorias'=> $categories];

    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $categorie = new Categorie();
        $categorie->nombre = $request->nombre;
        $categorie->descripcion = $request->descripcion;
        $categorie->condicion = '1';
        $categorie->save();
    }

   
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        $categorie = Categorie::findOrFail($request->id);
        $categorie->nombre = $request->nombre;
        $categorie->descripcion = $request->descripcion;
        $categorie->condicion = '1';
        $categorie->save();
    }

    public function desactivate(Request $request)
    {

        if(!$request->ajax()) return redirect('/');


        $categorie = Categorie::findOrFail($request->id);
        $categorie->condicion = '0';
        $categorie->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        $categorie = Categorie::findOrFail($request->id);
        $categorie->condicion = '1';
        $categorie->save();
    }

  
}
