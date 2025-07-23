<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom_entreprise' => 'Administration Eat&Drink',
            'email' => 'admin@eatdrink.com',
            'password' => Hash::make('Sametk75@'), 
            'role' => 'admin',
            'email_verified_at' => now(), 
        ]);
    }
}
