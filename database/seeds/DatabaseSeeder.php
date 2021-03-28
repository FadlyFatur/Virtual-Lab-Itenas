<?php

use Illuminate\Database\Seeder;
use App\mahasiswa;
use App\dosen;
use App\jurusan;
use App\kelas_praktikum;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = factory(mahasiswa::class)->create();
        $data = factory(dosen::class)->create();
        $this->call(UserSeeder::class);
        $data = factory(jurusan::class)->create();
        $data = factory(kelas_praktikum::class)->create();
    }
}
