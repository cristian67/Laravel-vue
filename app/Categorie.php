<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{


    protected $fillable = ['nombre','descripcion','condicion'];


    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    protected $table = 'categories';
}
