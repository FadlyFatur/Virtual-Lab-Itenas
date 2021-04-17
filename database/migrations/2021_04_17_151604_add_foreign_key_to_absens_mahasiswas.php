<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToAbsensMahasiswas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absen_mahasiswas', function (Blueprint $table) {
            $table->foreign('absen_id')
                ->references('id')
                ->on('absens')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('absen_mahasiswas', function (Blueprint $table) {
            $table->dropForeign('absen_mahasiswas_absen_id_foreign');
            $table->dropForeign('absen_mahasiswas_user_id_foreign');
        });
    }
}
