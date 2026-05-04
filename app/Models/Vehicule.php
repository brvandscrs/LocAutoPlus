<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'categorie_id',
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'km_actuel',
        'statut',
        'photo_url',
    ];

    // Un véhicule appartient à une catégorie
    public function categorie()
    {
        return $this->belongsTo(CategorieVehicule::class, 'categorie_id');
    }

    // Un véhicule a plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    // Un véhicule a plusieurs sinistres (via ses contrats)
    public function sinistres()
    {
        return $this->hasManyThrough(Sinistre::class, Contrat::class);
    }
}
