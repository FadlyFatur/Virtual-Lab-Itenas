<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->string('nama',100);
            $table->string('slug');
            $table->text('deskripsi')->nullable();
            $table->text('materi',100);
            $table->string('img_path')->nullable();
            $table->string('judul_file',100)->nullable();
            $table->string('file')->nullable();
            $table->string('link_materi')->nullable();
            $table->foreignId('praktikum_id')
                ->nullable()
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
        Schema::dropIfExists('materis');
    }
}
