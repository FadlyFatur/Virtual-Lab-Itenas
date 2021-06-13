<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToRekrutmens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekrutmens', function (Blueprint $table) {
            $table->foreign('praktikum_id')
                ->references('id')
                ->on('praktikums')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekrutmens', function (Blueprint $table) {
            $table->dropForeign('rekrutmens_praktikum_id_foreign');
        });
    }
}
