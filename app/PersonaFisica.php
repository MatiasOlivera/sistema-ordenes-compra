<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonaFisica extends Model
{
    use SoftDeletes;
    
    protected $table = 'personas_fisicas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['nombres', 'apellidos', 'documento', 'fecha_nacimiento', 'sexo'];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */

    protected $dates = ['created_at', 'updated_at','deleted_at'];

    /**
     * obtener persona relacionada con esta personaFisica
     */

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'id', 'id');
    }
}
