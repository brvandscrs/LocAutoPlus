<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicule;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicules = [
            ['categorie_id' => 1, 'immatriculation' => 'AB-123-CD', 'marque' => 'Renault',    'modele' => 'Clio',        'annee' => 2022, 'km_actuel' => 15000, 'statut' => 'disponible'],
            ['categorie_id' => 1, 'immatriculation' => 'EF-456-GH', 'marque' => 'Peugeot',    'modele' => '208',         'annee' => 2023, 'km_actuel' => 8000,  'statut' => 'disponible'],
            ['categorie_id' => 2, 'immatriculation' => 'IJ-789-KL', 'marque' => 'Volkswagen', 'modele' => 'Passat',      'annee' => 2022, 'km_actuel' => 22000, 'statut' => 'disponible'],
            ['categorie_id' => 2, 'immatriculation' => 'MN-012-OP', 'marque' => 'Toyota',     'modele' => 'Camry',       'annee' => 2023, 'km_actuel' => 5000,  'statut' => 'disponible'],
            ['categorie_id' => 3, 'immatriculation' => 'QR-345-ST', 'marque' => 'Peugeot',    'modele' => '3008',        'annee' => 2023, 'km_actuel' => 12000, 'statut' => 'disponible'],
            ['categorie_id' => 3, 'immatriculation' => 'UV-678-WX', 'marque' => 'Renault',    'modele' => 'Kadjar',      'annee' => 2022, 'km_actuel' => 18000, 'statut' => 'disponible'],
            ['categorie_id' => 4, 'immatriculation' => 'YZ-901-AB', 'marque' => 'Citroën',    'modele' => 'Berlingo',    'annee' => 2021, 'km_actuel' => 35000, 'statut' => 'disponible'],
            ['categorie_id' => 5, 'immatriculation' => 'CD-234-EF', 'marque' => 'Mercedes',   'modele' => 'Classe E',    'annee' => 2023, 'km_actuel' => 3000,  'statut' => 'disponible'],
            ['categorie_id' => 5, 'immatriculation' => 'GH-567-IJ', 'marque' => 'BMW',        'modele' => 'Série 5',     'annee' => 2023, 'km_actuel' => 4500,  'statut' => 'disponible'],
        ];

        foreach ($vehicules as $vehicule) {
            Vehicule::create($vehicule);
        }
    }
}
