<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToLabs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('labs', function (Blueprint $table) {
            $table->foreign('jurusan')
                ->references('id')
                ->on('jurusans')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('kepala_lab')
                ->references('nomer_id')
                ->on('dosens')
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
        Schema::table('labs', function (Blueprint $table) {
            $table->dropForeign('labs_kepala_lab_foreign');
            $table->dropForeign('labs_jurusan_foreign');
        });
    }
}
