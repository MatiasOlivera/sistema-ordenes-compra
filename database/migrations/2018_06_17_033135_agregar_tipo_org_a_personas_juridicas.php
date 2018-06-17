<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarTipoOrgAPersonasJuridicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('personas_juridicas', function (Blueprint $table) {
        $table->unsignedInteger('tipos_organizacion_id')->after('cuit');

        // foranea
        $table->foreign('tipos_organizacion_id')
            ->references('id')
            ->on('tipos_organizacion');
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
        $table->dropForeign(['tipos_organizacion_id']);
        $table->dropColumn('tipos_organizacion_id');
      });
    }
}
