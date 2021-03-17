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
            $table->boolean('status')->default(1);
            $table->integer('jabatan');
            $table->foreignId('mahasiswa_id')
                ->nullable()
                ->constrained('mahasiswas')
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
