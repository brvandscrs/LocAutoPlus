<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sinistre extends Model
{
    protected $fillable = [
        'contrat_id',
        'date_sinistre',
        'description',
        'cout_estime',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_sinistre' => 'date',
            'cout_estime'   => 'decimal:2',
        ];
    }

    // Un sinistre appartient à un contrat
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}
