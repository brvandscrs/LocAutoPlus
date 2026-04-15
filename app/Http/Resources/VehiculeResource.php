<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'immatriculation' => $this->immatriculation,
            'marque' => $this->marque,
            'modele' => $this->modele,
            'motorisation' => $this->motorisation,
            'nb_portes' => $this->nb_portes,
            'nb_places' => $this->nb_places,
            'type_boite_vitesse' => $this->type_boite_vitesse,
            'prix_journalier' => $this->prix_journalier,
            'image_url' => $this->image_url,
            'age_minimum' => $this->age_minimum,
        ];
    }
}