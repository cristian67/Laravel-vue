<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = ['nombre','descripcion','condicion'];

    protected $table = 'roles';

    public $timestamps = false;


    public function users()
    {
        return $this->hasMany('App\User');
    }
    
}
