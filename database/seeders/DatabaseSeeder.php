<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contrat;
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

        User::factory(20)->create();
        User::create([
            'name' => 'Dupont',
            'prenom'     => 'Bryan',
            'email'    => 'admin@example.com',
            'password' => Hash::make('motdepasse'),
        ]);

        $this->call(VehiculeSeeder::class);
        Contrat::factory(20)->create();
    }
}
