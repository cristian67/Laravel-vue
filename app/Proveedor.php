<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    protected $fillable = ['id','contacto','telefono_contacto'];

    protected $table = 'proveedores';

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

}
