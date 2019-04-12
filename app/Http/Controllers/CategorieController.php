<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategorieController extends Controller
{
  
    public function index()
    {
        $categorie = Categorie::all();
        return $categorie;
    }

 
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $categorie = new Categorie();
        $categorie->nombre = $request->nombre;
        $categorie->descripcion = $request->descripcion;
        $categorie->condicion = '1';
        $categorie->save();
    }

    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $categorie = Categorie::findOrFail($request->id);
        $categorie->nombre = $request->nombre;
        $categorie->descripcion = $request->descripcion;
        $categorie->condicion = '1';
        $categorie->save();
    }

    public function desactivate(Request $request)
    {
        $categorie = Categorie::findOrFail($request->id);
        $categorie->condicion = '0';
        $categorie->save();
    }

    public function activate(Request $request)
    {
        $categorie = Categorie::findOrFail($request->id);
        $categorie->condicion = '1';
        $categorie->save();
    }

    public function destroy($id)
    {
        //
    }
}
