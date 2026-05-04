<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'adresse',
        'date_naissance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_naissance'    => 'date',
            'password'          => 'hashed',
        ];
    }

    // Un client a plusieurs contrats
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    // Un client peut être membre du club
    public function clubMembre()
    {
        return $this->hasOne(ClubMembre::class);
    }

    // Un client a un historique de points
    public function historiquePoints()
    {
        return $this->hasMany(HistoriquePoint::class);
    }
}
