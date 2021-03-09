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
    }
}
