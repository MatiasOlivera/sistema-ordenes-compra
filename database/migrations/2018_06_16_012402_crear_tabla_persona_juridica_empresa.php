<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPersonaJuridicaEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_juridica_empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('persona_juridica_id');
            $table->unsignedInteger('empresa_id');

            // Created_at, updated_at y deleted_at
            $table->timestamps();
            $table->softDeletes();

            // Clave primaria y foráneas
            $table->foreign('persona_juridica_id')
                ->references('id')
                ->on('personas_juridicas');

            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas');

            // Indices
            $table->unique(['persona_juridica_id', 'empresa_id']);
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
        Schema::dropIfExists('persona_juridica_empresa');
        Schema::enableForeignKeyConstraints();
    }
}
