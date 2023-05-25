<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'first_name'=>'Stephen',
            'last_name'=>'Feddes',
            "username"=>'steve',
            'department_name'=>'Support',
            'email'=>'stevepfeddes@gmail.com',
            'phone_number'=>'708-964-5875',
            'password'=>Hash::make('secret')
        ]);
    }
}
