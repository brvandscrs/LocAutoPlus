<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieVehicule extends Model
{
    protected $table = 'categories_vehicules';

    protected $fillable = [
        'nom',
        'description',
        'tarif_base_jour',
    ];

    protected function casts(): array
    {
        return [
            'tarif_base_jour' => 'decimal:2',
        ];
    }

    // Une catégorie a plusieurs véhicules
    public function vehicules()
    {
        return $this->hasMany(Vehicule::class, 'categorie_id');
    }
}
