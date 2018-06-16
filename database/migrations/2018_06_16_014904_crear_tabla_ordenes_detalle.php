<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOrdenesDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('orden_id');

            // Created_at, updated_at y deleted_at
            $table->timestamps();
            $table->softDeletes();

            // Clave foráneas
            $table->foreign('orden_id')->references('id')->on('ordenes');
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
        Schema::dropIfExists('ordenes_detalle');
        Schema::enableForeignKeyConstraints();
    }
}
