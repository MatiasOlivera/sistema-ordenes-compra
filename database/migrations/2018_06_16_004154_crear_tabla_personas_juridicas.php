<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPersonasJuridicas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas_juridicas', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('denominacion', 100);

            $table->unsignedBigInteger('cuit')
                ->nullable()
                ->unique();

            // Created_at, updated_at y deleted_at
            $table->timestamps();
            $table->softDeletes();

            // Clave primaria y foráneas
            $table->primary('id');
            $table->foreign('id')->references('id')->on('personas');
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
        Schema::dropIfExists('personas_juridicas');
        Schema::enableForeignKeyConstraints();
    }
}
