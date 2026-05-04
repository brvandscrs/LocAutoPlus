<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nom'            => 'Durand',
                'prenom'         => 'Jean',
                'email'          => 'jean.durand@email.fr',
                'password'       => Hash::make('Client1234!'),
                'telephone'      => '0612345678',
                'adresse'        => '12 rue des Lilas, 30000 Nîmes',
                'date_naissance' => '1985-03-15',
            ],
            [
                'nom'            => 'Leroy',
                'prenom'         => 'Camille',
                'email'          => 'camille.leroy@email.fr',
                'password'       => Hash::make('Client1234!'),
                'telephone'      => '0698765432',
                'adresse'        => '5 avenue Gambetta, 30000 Nîmes',
                'date_naissance' => '1992-07-22',
            ],
            [
                'nom'            => 'Petit',
                'prenom'         => 'Thomas',
                'email'          => 'thomas.petit@email.fr',
                'password'       => Hash::make('Client1234!'),
                'telephone'      => '0756789012',
                'adresse'        => '8 boulevard Victor Hugo, 30900 Nîmes',
                'date_naissance' => '1978-11-30',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
