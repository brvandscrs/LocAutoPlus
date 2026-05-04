<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contrat;
use App\Models\ClubMembre;
use App\Models\NiveauClub;
use App\Models\HistoriquePoint;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class ContratApiController extends Controller
{
    public function cloturer(Request $request, $id)
    {
        $contrat = Contrat::with('user')->findOrFail($id);

        if ($contrat->statut !== 'en_cours') {
            return response()->json([
                'success' => false,
                'message' => 'Ce contrat ne peut pas être clôturé (statut : ' . $contrat->statut . ').',
            ], 422);
        }

        $request->validate([
            'km_retour'       => 'required|integer',
            'date_fin_reelle' => 'required|date',
        ]);

        // Mise à jour du contrat
        $contrat->update([
            'statut'          => 'terminee',
            'km_retour'       => $request->km_retour,
            'date_fin_reelle' => $request->date_fin_reelle,
        ]);

        // Mise à jour kilométrage véhicule
        Vehicule::where('id', $contrat->vehicule_id)->update([
            'km_actuel' => $request->km_retour,
            'statut'    => 'disponible',
        ]);

        // Calcul et attribution des points (1 point par euro dépensé)
        $points = (int) $contrat->montant_total;

        HistoriquePoint::create([
            'user_id'    => $contrat->user_id,
            'contrat_id' => $contrat->id,
            'points'     => $points,
            'motif'      => 'Location terminée — Contrat #' . $contrat->id,
        ]);

        // Mise à jour ou création du profil club
        $this->mettreAJourClub($contrat->user_id, $points);

        return response()->json([
            'success' => true,
            'message' => 'Contrat clôturé avec succès.',
            'points_attribues' => $points,
        ]);
    }

    private function mettreAJourClub($userId, $pointsGagnes)
    {
        $membre = ClubMembre::where('user_id', $userId)->first();

        if ($membre) {
            $membre->points_total += $pointsGagnes;
        } else {
            $niveauBronze = NiveauClub::where('points_min', 0)->first();
            $membre = ClubMembre::create([
                'user_id'       => $userId,
                'niveau_id'     => $niveauBronze->id,
                'points_total'  => $pointsGagnes,
                'date_adhesion' => now(),
                'actif'         => true,
            ]);
        }

        // Vérification montée en niveau
        $nouveauNiveau = NiveauClub::where('points_min', '<=', $membre->points_total)
            ->orderBy('points_min', 'desc')
            ->first();

        if ($nouveauNiveau && $nouveauNiveau->id !== $membre->niveau_id) {
            $membre->niveau_id = $nouveauNiveau->id;
        }

        $membre->save();
    }
}
