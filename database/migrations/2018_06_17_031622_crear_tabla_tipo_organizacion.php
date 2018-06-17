<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTipoOrganizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tipos_organizacion', function (Blueprint $table) {
          $table->increments('id');
          $table->string('descripcion', 50);

          //timestamps
          $table->timeStamps();

          // Deleted_at
          $table->softDeletes();

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tipos_organizacion');
    }
}
