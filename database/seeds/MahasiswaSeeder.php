<?php

use Illuminate\Database\Seeder;
use App\mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => $faker->name,
            'nrp' => $faker->unique()->numberBetween(1, 50),
        ];
        mahasiswa::create($data);
    }
}
