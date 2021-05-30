<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToAssistens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assistens', function (Blueprint $table) {
            $table->foreign('mahasiswa_id')
                ->references('nrp')
                ->on('mahasiswas')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('praktikum_id')
                ->references('id')
                ->on('praktikums')
                ->onDelete('restrict')
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
        Schema::table('assistens', function (Blueprint $table) {
            $table->dropForeign('assistens_mahasiswa_id_foreign');
            $table->dropForeign('assistens_praktikum_id_foreign');
        });
    }
}
