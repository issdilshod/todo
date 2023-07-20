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
        // Create first user
        $firstUser = [
            'email' => 'admin@example.com',
            'password' => Hash::make('123qweAS!'),
            'name' => 'Admin'
        ];

        \App\Models\User::create($firstUser);
    }
}
