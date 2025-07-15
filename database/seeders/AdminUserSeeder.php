<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'shahrabifatemeh87@gmail.com',
            'password' => Hash::make('fatemeh_87'),
            'is_admin' => true,
        ]);
    }
}