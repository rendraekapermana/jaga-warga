<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🛡️ SuperAdmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'), 
            'role' => 'SuperAdmin',
        ]);

        // 🧠 Psychologist
        User::create([
            'name' => 'Dr. Psychologist',
            'email' => 'psychologist@example.com',
            'password' => Hash::make('password'),
            'role' => 'Psychologist',
        ]);

        // 👤 User Biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'User',
        ]);

        // Kamu juga bisa tambahkan dummy user tambahan kalau mau
        // User::factory(5)->create();
    }
}
