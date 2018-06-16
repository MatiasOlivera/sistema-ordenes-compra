<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->unsignedInteger('id');

            // Created_at, updated_at y deleted_at
            $table->timestamps();
            $table->softDeletes();

            // Clave primaria y foráneas
            $table->primary('id');
            $table->foreign('id')->references('id')->on('empresas');
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
        Schema::dropIfExists('proveedores');
        Schema::enableForeignKeyConstraints();
    }
}
