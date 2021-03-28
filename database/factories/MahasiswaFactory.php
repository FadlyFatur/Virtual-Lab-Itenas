<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\mahasiswa;
use Faker\Generator as Faker;

$factory->define(mahasiswa::class, function (Faker $faker) {
    return [
        'nama' => 'fadly',
        'nrp' => '152017076',
    ];
});
