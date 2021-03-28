<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePraktikumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praktikums', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->string('nama');
            $table->string('slug');
            $table->text('deskripsi')->nullable();
            $table->string('semester');
            $table->string('tahun_ajaran');
            $table->foreignId('laboratorium')
                ->nullable()
                ->constrained('labs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('kelas')
                ->nullable()
                ->constrained('kelas_praktikums')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                $table->foreignId('koor_lab')
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
        Schema::dropIfExists('praktikums');
    }
}
