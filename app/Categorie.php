<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{


    protected $fillable = ['nombre','descripcion','condicion'];


    protected $table = 'categories';
}
