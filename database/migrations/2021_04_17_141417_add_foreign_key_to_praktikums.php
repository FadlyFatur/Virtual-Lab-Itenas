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
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('kelas')
                ->references('id')
                ->on('kelas_praktikums')
                ->onUpdate('cascade');
            $table->foreign('koor_dosen_prak')
                ->references('nomer_id')
                ->on('dosens')
                ->onUpdate('cascade');
            $table->foreign('koor_assisten')
                ->references('nrp')
                ->on('mahasiswas')
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
            $table->dropForeign('praktikums_koor_dosen_prak_foreign');
            $table->dropForeign('praktikums_koor_assisten_foreign');
        });
    }
}
