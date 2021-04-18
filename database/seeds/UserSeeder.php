<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = [
            'name' => "Admin",
            'email' => "admin@example.com",
            'roles_id' => 0,
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(10),
        ];
        if(!User::where('email',$adminUser['email'])->exists()){
            User::create($adminUser);
        }

        $user = [
            'name' => "user",
            'email' => "user@test.com",
            'roles_id' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            'remember_token' => Str::random(10),
        ];
        if(!User::where('email',$user['email'])->exists()){
            User::create($user);
        }

        $mahasiswa = [
            'name' => "mahasiswa",
            'email' => "mahasiswa@test.com",
            'nrp' => "152017076",
            'roles_id' => 2,
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            'remember_token' => Str::random(10),
        ];
        
        if(!User::where('email',$mahasiswa['email'])->exists()){
            User::create($mahasiswa);
        }

        $dosen = [
            'name' => "dosen",
            'email' => "dosen@test.com",
            'nomer_id' => "001",
            'roles_id' => 3,
            'email_verified_at' => now(),
            'password' => bcrypt('12345'),
            'remember_token' => Str::random(10),
        ];
        
        if(!User::where('email',$dosen['email'])->exists()){
            User::create($dosen);
        }
    }
}
