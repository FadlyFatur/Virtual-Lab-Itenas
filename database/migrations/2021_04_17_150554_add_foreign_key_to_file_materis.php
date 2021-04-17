<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToFileMateris extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_materis', function (Blueprint $table) {
            $table->foreign('materi_id')
                ->references('id')
                ->on('materis')
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
        Schema::table('file_materis', function (Blueprint $table) {
            $table->dropForeign('file_materis_materi_id_foreign');
        });
    }
}
