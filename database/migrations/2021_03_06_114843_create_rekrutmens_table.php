<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekrutmensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekrutmens', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->integer('kuota')->default(3);
            $table->date('deadline');
            $table->text('deskripsi');
            $table->string('nama')->nullable();
            $table->string('file');
            $table->foreignId('praktikum_id')
                ->constrained('praktikums')
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
        Schema::dropIfExists('rekrutmens');
    }
}
