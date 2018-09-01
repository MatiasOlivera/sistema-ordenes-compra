<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoOrganizacion extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_organizacion';

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
        'descripcion'
    ];

    /**
     * Obtener las personas jurídicas que pertenezcan a este tipo de organización
     */

    public function juridicas()
    {
        return $this->hasMany('App\PersonaJuridica');
    }
}
