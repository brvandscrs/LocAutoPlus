<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Employe extends Authenticatable
{
    use HasApiTokens;
    
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'actif',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'actif'    => 'boolean',
            'password' => 'hashed',
        ];
    }

    // Un employé gère plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
