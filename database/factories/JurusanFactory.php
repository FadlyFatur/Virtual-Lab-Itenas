<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\jurusan;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
// use Carbon;

$factory->define(jurusan::class, function (Faker $faker) {
    $nama = 'Informatika';
    return [
        'nama' => $nama,
        'slug' => Str::slug($nama),
        'deskripsi' => 'Informatika merupakan disiplin ilmu komputer yaitu data maupun informasi pada mesin berbasis komputasi. Disiplin ilmu ini mencakup beberapa macam bidang.',
    ];
});
