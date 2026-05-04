<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employe;
use Illuminate\Support\Facades\Hash;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employes = [
            [
                'nom'      => 'Dupont',
                'prenom'   => 'Marie',
                'email'    => 'admin@locautoplus.fr',
                'password' => Hash::make('Admin1234!'),
                'role'     => 'admin',
                'actif'    => true,
            ],
            [
                'nom'      => 'Martin',
                'prenom'   => 'Lucas',
                'email'    => 'agent1@locautoplus.fr',
                'password' => Hash::make('Agent1234!'),
                'role'     => 'agent',
                'actif'    => true,
            ],
            [
                'nom'      => 'Bernard',
                'prenom'   => 'Sophie',
                'email'    => 'agent2@locautoplus.fr',
                'password' => Hash::make('Agent1234!'),
                'role'     => 'agent',
                'actif'    => true,
            ],
        ];

        foreach ($employes as $employe) {
            Employe::create($employe);
        }
    }
}
