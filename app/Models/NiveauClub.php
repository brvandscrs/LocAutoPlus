<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NiveauClub extends Model
{
    protected $table = 'niveaux_club';

    protected $fillable = [
        'nom',
        'points_min',
        'reduction_pct',
    ];

    protected function casts(): array
    {
        return [
            'reduction_pct' => 'decimal:2',
        ];
    }

    // Un niveau concerne plusieurs membres du club
    public function clubMembres()
    {
        return $this->hasMany(ClubMembre::class, 'niveau_id');
    }
}
