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
        $this->call(UserSeeder::class);
        // $data = factory(mahasiswa::class, 100)->create();
        // $data = factory(dosen::class, 100)->create();
        $data = factory(jurusan::class, 1)->create();
        $data = factory(kelas_praktikum::class, 1)->create();
    }
}
