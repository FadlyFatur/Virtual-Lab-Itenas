<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignDosenRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dosen_roles', function (Blueprint $table) {
            $table->foreign('dosen_id')
                ->references('nomer_id')
                ->on('dosens')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('praktikum_id')
                ->references('id')
                ->on('praktikums')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusans')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('lab_id')
                ->references('id')
                ->on('labs')
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
        Schema::table('dosen_roles', function (Blueprint $table) {
            $table->dropForeign('dosen_roles_dosen_id_foreign');
            $table->dropForeign('dosen_roles_praktikum_id_foreign');
            $table->dropForeign('dosen_roles_jurusan_id_foreign');
        });
    }
}
