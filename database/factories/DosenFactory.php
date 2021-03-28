<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\dosen;
use Faker\Generator as Faker;

$factory->define(dosen::class, function (Faker $faker) {
    return [
        'nama' => 'rohman',
        'nomer_id' => '001',
    ];
});
