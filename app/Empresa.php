<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empresas';

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_fantasia', 'es_mayorista'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'es_mayorista' => 'boolean',
    ];

    /**
     * Obtener las personas jurídicas que son dueñas de esta empresa
     */
    public function juridicas()
    {
        return $this->belongsToMany('App\PersonaJuridica', 'persona_juridica_empresa')
            ->withTimestamps();
    }

    /**
     * Dar de alta la empresa como proveedor
     */
    public function proveedor()
    {
        return $this->hasOne('App\Proveedor', 'id');
    }
    
    /**
     * Obtener las actividades económicas a las que se dedica esta empresa
     */
    public function actividades()
    {
        return $this->belongsToMany('App\ActividadEconomica', 'empresa_actividad')
            ->withTimestamps();
    }
}
