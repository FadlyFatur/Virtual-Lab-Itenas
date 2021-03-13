<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\mahasiswa;
use Faker\Generator as Faker;

$factory->define(mahasiswa::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'nomer_unik' => $faker->unique()->numberBetween(1, 1000),
    ];
});
