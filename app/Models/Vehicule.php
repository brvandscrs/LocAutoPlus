<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculeFactory> */
    use HasFactory;

    protected $fillable = [
        'immatriculation',
        'motorisation',
        'nb_porte',
        'nb_place',
        'type_boite_vitesse',
        'prix_journalier',
    ];
}
