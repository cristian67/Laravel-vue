<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['idcategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'];

    public function categorie()
    {
        return $this->belongsTo('App\Categorie');
    }

    protected $table = 'articles';
}
