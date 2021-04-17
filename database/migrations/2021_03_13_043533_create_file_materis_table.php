<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileMaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_materis', function (Blueprint $table) {
            $table->id();
            $table->string('nama',200);
            $table->text('materi',10000)->nullable();
            $table->string('img')->nullable();
            $table->string('file')->nullable();
            $table->string('link')->nullable();
            $table->text('tugas',2000)->nullable();
            $table->integer('type');
            $table->foreignId('materi_id')->nullable();
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
        Schema::dropIfExists('file_materis');
    }
}
