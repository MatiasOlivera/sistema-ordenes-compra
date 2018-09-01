<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadEconomica extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actividades_economicas';

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
    protected $fillable = ['descripcion'];

    /**
     * Obtener las empresas que se dedican a esta actividad económica
     */
    public function empresas()
    {
        return $this->belongsToMany('App\Empresa', 'empresa_actividad')
            ->withTimestamps();
    }
}
