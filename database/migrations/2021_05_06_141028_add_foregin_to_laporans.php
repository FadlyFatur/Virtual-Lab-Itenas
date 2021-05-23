<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeginToLaporans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->foreign('penerima')
                ->references('nomer_id')
                ->on('dosens')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('pengirim')
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
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign('laporans_penerima_foreign');
            $table->dropForeign('laporans_pengirim_foreign');
        });
    }
}
