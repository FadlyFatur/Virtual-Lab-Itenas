<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToUserRekrutmens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_rekrutmens', function (Blueprint $table) {
            $table->foreign('rekrut_id')
                ->references('id')
                ->on('rekrutmens')
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
        Schema::table('user_rekrutmens', function (Blueprint $table) {
            $table->dropForeign('user_rekrutmens_rekrut_id_foreign');
            $table->dropForeign('user_rekrutmens_user_id_foreign');
        });
    }
}
