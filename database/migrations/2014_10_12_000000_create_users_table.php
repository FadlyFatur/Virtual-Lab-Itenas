<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('roles_id')->default(1);
            $table->boolean('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nomer_id')->nullable()->unique();
            $table->foreign('nomer_id')
                    ->references('nomer_id')
                    ->on('dosens')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('nrp')->nullable()->unique();
            $table->foreign('nrp')
                    ->references('nrp')
                    ->on('mahasiswas')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
