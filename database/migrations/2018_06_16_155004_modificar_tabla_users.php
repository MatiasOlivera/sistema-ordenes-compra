<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarTablaUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->string('username')
                ->after('id');

            $table->string('display_name')
                ->nullable()
                ->after('username');

            $table->string('email')
                ->nullable()
                ->change();

            $table->boolean('authorized')
                ->after('password')
                ->default(false);

            $table->unsignedInteger('persona_fisica_id')
                ->nullable()
                ->after('remember_token');

            // Claves foráneas
            $table->foreign('persona_fisica_id')
                ->references('id')
                ->on('personas_fisicas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->string('name');
            $table->dropForeign(['persona_fisica_id']);
            $table->dropColumn([
                'username',
                'display_name',
                'authorized',
                'persona_fisica_id'
            ]);
            $table->string('email')->change();
            Schema::enableForeignKeyConstraints();
        });
    }
}
