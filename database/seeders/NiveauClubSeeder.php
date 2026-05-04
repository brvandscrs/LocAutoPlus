<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NiveauClub;

class NiveauClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            ['nom' => 'Bronze', 'points_min' => 0,   'reduction_pct' => 5.00],
            ['nom' => 'Silver', 'points_min' => 500,  'reduction_pct' => 10.00],
            ['nom' => 'Gold',   'points_min' => 1500, 'reduction_pct' => 15.00],
        ];

        foreach ($niveaux as $niveau) {
            NiveauClub::create($niveau);
        }
    }
}
