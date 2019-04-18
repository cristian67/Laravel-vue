<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar=='')
        {
            $article = Article::join('categories','articles.idcategoria','=','categories.id')
                                    ->select('articles.id',
                                                'articles.idcategoria',
                                                'articles.codigo',
                                                'articles.nombre',
                                                'categories.nombre as categoria',
                                                'articles.precio_venta',
                                                'articles.stock',
                                                'articles.descripcion',
                                                'articles.condicion')
                                    ->orderBy('articles.id','desc')->paginate(3);
        }
        else
        {   
            $article = Article::join('categories','article.idcategoria','=','categories.id')
                                ->select('article.id',
                                            'article.idcategoria',
                                            'article.codigo',
                                            'article.nombre',
                                            'categories.nombre as categoria',
                                            'article.precio_venta',
                                            'article.stock',
                                            'article.descripcion',
                                            'article.condicion')
                                ->where('article.'.$criterio,'like','%'. $buscar . '%')
                                ->orderBy('article.id','desc')->paginate(3);
        }
        return [

            'pagination' => 
            [
                'total' => $article->total(),
                'current_page' => $article->currentPage(),
                'per_page' => $article->perPage(),
                'last_page' => $article->lastPage(),
                'from' => $article->firstItem(),
                'to' => $article->lastItem()
            ],
            'articles' => $article
        ];
    }

 
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $article = new Article();
        $article->idcategoria = $request->idcategoria;
        $article->codigo = $request->codigo;
        $article->nombre = $request->nombre;
        $article->precio_venta = $request->precio_venta;
        $article->stock = $request->stock;
        $article->descripcion = $request->descripcion;
        $article->condicion = '1';
        $article->save();
    }

   
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        $article = Article::findOrFail($request->id);
        $article->idcategoria = $request->idcategoria;
        $article->codigo = $request->codigo;
        $article->nombre = $request->nombre;
        $article->precio_venta = $request->precio_venta;
        $article->stock = $request->stock;
        $article->descripcion = $request->descripcion;
        $article->condicion = '1';
        $article->save();
    }

    public function desactivate(Request $request)
    {

        if(!$request->ajax()) return redirect('/');


        $article = Article::findOrFail($request->id);
        $article->condicion = '0';
        $article->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $article = Article::findOrFail($request->id);
        $article->condicion = '1';
        $article->save();
    }

}
