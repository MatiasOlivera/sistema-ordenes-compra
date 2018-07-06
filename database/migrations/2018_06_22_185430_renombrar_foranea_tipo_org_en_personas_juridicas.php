<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenombrarForaneaTipoOrgEnPersonasJuridicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas_juridicas', function (Blueprint $table) {
            $table->renameColumn(
                'tipos_organizacion_id',
                'tipo_organizacion_id'
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
        Schema::table('personas_juridicas', function (Blueprint $table) {
            $table->renameColumn(
                'tipo_organizacion_id',
                'tipos_organizacion_id'
            );
        });
    }
}
