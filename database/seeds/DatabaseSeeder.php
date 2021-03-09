<?php

use Illuminate\Database\Seeder;
use App\mahasiswa;
use App\dosen;

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
        $data = factory(mahasiswa::class, 100)->create();
        $data = factory(dosen::class, 100)->create();
    }
}
