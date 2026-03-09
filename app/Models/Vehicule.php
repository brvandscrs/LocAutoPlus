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
        'marque',
        'modele',
        'motorisation',
        'nb_portes',
        'nb_places',
        'type_boite_vitesse',
        'prix_journalier',
        'image_url',
        'age_minimum',
    ];
}
