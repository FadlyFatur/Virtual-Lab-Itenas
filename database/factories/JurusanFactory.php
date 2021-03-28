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
        'deskripsi' => $faker->sentence($nbWords = 50, $variableNbWords = true),
    ];
});
