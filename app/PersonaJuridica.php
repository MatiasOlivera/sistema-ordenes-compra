<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonaJuridica extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personas_juridicas';

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
        'denominacion', 'cuit', 'tipo_organizacion_id'
    ];

    /**
     * Obtener la persona asociada a esta persona jurídica
     */

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'id');
    }

    /**
     * Obtener el tipo de organización de esta persona jurídica
     */
    public function tipoOrganizacion()
    {
        return $this->belongsTo('App\TipoOrganizacion');
    }
    
    /**
     * Obtener las empresas que pertenecen a esta persona jurídica
     */
    public function empresas()
    {
        return $this->belongsToMany('App\Empresa', 'persona_juridica_empresa')
            ->withTimestamps();
    }
}
