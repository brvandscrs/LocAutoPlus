<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    protected $fillable = [
        'user_id',
        'vehicule_id',
        'employe_id',
        'date_reservation',
        'date_debut',
        'date_fin_prevue',
        'date_fin_reelle',
        'km_depart',
        'km_retour',
        'montant_base',
        'reduction_appliquee',
        'montant_total',
        'statut',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_reservation'    => 'datetime',
            'date_debut'          => 'date',
            'date_fin_prevue'     => 'date',
            'date_fin_reelle'     => 'date',
            'montant_base'        => 'decimal:2',
            'reduction_appliquee' => 'decimal:2',
            'montant_total'       => 'decimal:2',
        ];
    }

    // Un contrat appartient à un client
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un contrat concerne un véhicule
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    // Un contrat est géré par un employé
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    // Un contrat peut avoir des sinistres
    public function sinistres()
    {
        return $this->hasMany(Sinistre::class);
    }

    // Un contrat génère des points
    public function historiquePoints()
    {
        return $this->hasMany(HistoriquePoint::class);
    }
}
