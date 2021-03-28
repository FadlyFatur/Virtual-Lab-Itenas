<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistens', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(1);
            $table->integer('role')->default(1);
            $table->string('foto')->nullable();
            $table->foreignId('praktikum_id')
                ->constrained('praktikums')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('id_mahasiswa')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('assistens');
    }
}
