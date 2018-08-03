<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EliminarTablaRubros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rubros');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('rubros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 100)->unique();

            // Created_at, updated_at y deleted_at
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
