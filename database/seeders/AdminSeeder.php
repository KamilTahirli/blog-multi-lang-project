<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
        [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'rank' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'), // password
            'remember_token' => Str::random(10),
        ];

     

        User::create($data);
    }
}
