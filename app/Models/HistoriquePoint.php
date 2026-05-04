<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriquePoint extends Model
{
    protected $table = 'historique_points';

    protected $fillable = [
        'user_id',
        'contrat_id',
        'points',
        'motif',
    ];

    // Un point appartient à un client
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un point est lié à un contrat
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}
