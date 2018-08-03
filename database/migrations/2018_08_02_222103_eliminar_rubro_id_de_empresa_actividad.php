<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarRubroIdDeEmpresaActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_actividad', function (Blueprint $table) {
            // Eliminar la columna rubro_id
            $table->dropForeign(['rubro_id']);
            $table->dropColumn('rubro_id');
            
            // Eliminar las foráneas empresa_id y actividad_id
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['actividad_id']);
            
            // Eliminar el índique único empresa/actividad/rubro
            $table->dropUnique(['empresa_id', 'actividad_id', 'rubro_id']);
            
            // Crear las foráneas empresa_id y actividad_id
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas');

            $table->foreign('actividad_id')
                ->references('id')
                ->on('actividades_economicas');
            
            // Crear el índice único empresa/actividad
            $table->unique(['empresa_id', 'actividad_id']);
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
            // Crear la columna rubro_id
            $table->unsignedInteger('rubro_id')
                ->after('actividad_id');
            $table->foreign('rubro_id')
                ->references('id')
                ->on('rubros');
            
            // Eliminar las foráneas empresa_id y actividad_id
            $table->dropForeign(['empresa_id']);
            $table->dropForeign(['actividad_id']);
            
            // Eliminar el índique único empresa/actividad
            $table->dropUnique(['empresa_id', 'actividad_id']);
            
            // Crear las foráneas empresa_id y actividad_id
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas');

            $table->foreign('actividad_id')
                ->references('id')
                ->on('actividades_economicas');
            
            // Crear el índique único empresa/actividad/rubro
            $table->unique(['empresa_id', 'actividad_id', 'rubro_id']);
        });
    }
}
