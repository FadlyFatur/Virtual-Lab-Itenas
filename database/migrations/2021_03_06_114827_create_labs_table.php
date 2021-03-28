<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->string('nama');
            $table->string('slug');
            $table->text('deskripsi');
            $table->string('thumbnail');
            $table->foreignId('jurusan')
                ->constrained('jurusans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('kepala_lab')
                ->nullable()
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
        Schema::dropIfExists('labs');
    }
}
