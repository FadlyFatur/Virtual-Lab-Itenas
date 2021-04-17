<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRekrutmensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rekrutmens', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->string('biodata')->nullable();
            $table->string('transkip')->nullable();
            $table->string('file')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('rekrut_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rekrutmens');
    }
}
