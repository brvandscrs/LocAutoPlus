<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubMembre extends Model
{
    protected $table = 'club_membres';

    protected $fillable = [
        'user_id',
        'niveau_id',
        'points_total',
        'date_adhesion',
        'actif',
    ];

    protected function casts(): array
    {
        return [
            'date_adhesion' => 'date',
            'actif'         => 'boolean',
        ];
    }

    // Un membre du club est un client
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un membre a un niveau (Bronze/Silver/Gold)
    public function niveau()
    {
        return $this->belongsTo(NiveauClub::class, 'niveau_id');
    }
}
