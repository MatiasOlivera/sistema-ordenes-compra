<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenombrarActividadIdEnEmpresaActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_actividad', function (Blueprint $table) {
            // Renombrar la columna actividad_id
            $table->renameColumn('actividad_id', 'actividad_economica_id');
            
            // Crear la foránea con el nuevo nombre
            $table->dropForeign(['actividad_id']);
            $table->foreign('actividad_economica_id')
                ->references('id')
                ->on('actividades_economicas');
            
            // Renombrar el índice único empresa/actividad
            $table->renameIndex(
                'empresa_actividad_empresa_id_actividad_id_unique',
                'empresa_actividad_empresa_id_actividad_economica_id_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_actividad', function (Blueprint $table) {
            // Renombrar la columna actividad_economica_id
            $table->renameColumn('actividad_economica_id', 'actividad_id');
            
            // Crear la foránea con el nombre anterior
            $table->dropForeign(['actividad_economica_id']);
            $table->foreign('actividad_id')
                ->references('id')
                ->on('actividades_economicas');
            
            // Renombrar el índice único empresa/actividad
            $table->renameIndex(
                'empresa_actividad_empresa_id_actividad_economica_id_unique',
                'empresa_actividad_empresa_id_actividad_id_unique'
            );
        });
    }
}
