<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@kabuku.com',
            'name' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'email' => 'chaezaibnuakbar@gmail.com',
            'name' => 'Chaeza',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'email' => 'danishraihan@gmail.com',
            'name' => 'Danish',
            'password' => Hash::make('password'),
        ]);
    }
}
