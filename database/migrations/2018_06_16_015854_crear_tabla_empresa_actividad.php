<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpresaActividad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empresa_id');
            $table->unsignedInteger('actividad_id');
            $table->unsignedInteger('rubro_id');

            // Created_at, updated_at y deleted_at
            $table->timestamps();
            $table->softDeletes();

            // Clave primaria y foráneas
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas');

            $table->foreign('actividad_id')
                ->references('id')
                ->on('actividades_economicas');

            $table->foreign('rubro_id')
                ->references('id')
                ->on('rubros');

            // Indices
            $table->unique(['empresa_id', 'actividad_id', 'rubro_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('empresa_actividad');
        Schema::enableForeignKeyConstraints();
    }
}
