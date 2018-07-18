<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCantDescYMontoAOrdenesDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordenes_detalle', function (Blueprint $table) {
            $table->unsignedSmallInteger('cantidad')
                ->after('id');
            
            $table->string('descripcion', 100)
                ->after('cantidad');
            
            $table->decimal('importe', 9, 2)
                ->after('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordenes_detalle', function (Blueprint $table) {
            $table->dropColumn(['cantidad', 'descripcion', 'importe']);
        });
    }
}
