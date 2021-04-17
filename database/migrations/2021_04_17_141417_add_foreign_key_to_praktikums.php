<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPraktikums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('praktikums', function (Blueprint $table) {
            $table->foreign('laboratorium')
                ->references('id')
                ->on('labs')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('kelas')
                ->references('id')
                ->on('kelas_praktikums')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('koor_lab')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('koor_prak')
                ->references('id')
                ->on('users')
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
        Schema::table('praktikums', function (Blueprint $table) {
            $table->dropForeign('praktikums_laboratorium_foreign');
            $table->dropForeign('praktikums_kelas_foreign');
            $table->dropForeign('praktikums_koor_lab_foreign');
            $table->dropForeign('praktikums_koor_prak_foreign');
        });
    }
}
