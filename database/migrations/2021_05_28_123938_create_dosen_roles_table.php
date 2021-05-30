<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen_roles', function (Blueprint $table) {
            $table->id();
            $table->string('dosen_id');
            $table->boolean('status')->default(1);
            $table->integer('role')->default(0);
            $table->string('foto')->nullable();
            $table->foreignId('praktikum_id')->nullable();
            $table->foreignId('lab_id')->nullable();
            $table->foreignId('jurusan_id')->nullable();
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
        Schema::dropIfExists('dosen_roles');
    }
}
