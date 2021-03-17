<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->string('nama');
            $table->string('slug');
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->foreignId('ketua_jurusan')
                ->nullable()
                ->constrained('dosens')
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
        Schema::dropIfExists('jurusans');
    }
}
