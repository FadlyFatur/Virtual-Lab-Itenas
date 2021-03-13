<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\kelas_praktikum;
use Carbon\Carbon;;
use Faker\Generator as Faker;

$factory->define(kelas_praktikum::class, function (Faker $faker) {
    $nama = $faker->name;
    $date = Carbon::now();
    return [
        'nama' => $nama,
        'deskripsi' => $faker->sentence($nbWords = 50, $variableNbWords = true),
        'hari' => $faker->dayOfWeek($max = 'now'),
        'jadwal_mulai' => $date->format('H:i'),
        'jadwal_akhir' => $date->addHour(2)->format('H:i'),
    ];
});
