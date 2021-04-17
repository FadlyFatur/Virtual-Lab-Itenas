<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('nomer_id')
                    ->references('nomer_id')
                    ->on('dosens')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
            $table->foreign('nrp')
                    ->references('nrp')
                    ->on('mahasiswas')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_nomer_id_foreign');
            $table->dropForeign('users_nrp_foreign');
        });
    }
}
