<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClubMembre;
use App\Models\NiveauClub;
use App\Models\HistoriquePoint;

class ClubApiController extends Controller
{
    public function membres()
    {
        $membres = ClubMembre::with(['user', 'niveau'])
            ->orderByDesc('points_total')
            ->get()
            ->map(fn($m) => [
                'id'            => $m->id,
                'user_id'       => $m->user_id,
                'nom_complet'   => $m->user->prenom . ' ' . $m->user->nom,
                'email'         => $m->user->email,
                'points_total'  => $m->points_total,
                'niveau'        => $m->niveau->nom,
                'reduction_pct' => (float) $m->niveau->reduction_pct,
                'date_adhesion' => $m->date_adhesion?->format('d/m/Y'),
                'actif'         => $m->actif,
            ]);

        return response()->json(['success' => true, 'data' => $membres]);
    }

    public function niveaux()
    {
        $niveaux = NiveauClub::orderBy('points_min')->get()->map(fn($n) => [
            'id'            => $n->id,
            'nom'           => $n->nom,
            'points_min'    => $n->points_min,
            'reduction_pct' => (float) $n->reduction_pct,
            'nb_membres'    => ClubMembre::where('niveau_id', $n->id)->where('actif', true)->count(),
        ]);

        return response()->json(['success' => true, 'data' => $niveaux]);
    }

    public function verifier($userId)
    {
        $membre = ClubMembre::where('user_id', $userId)->with('niveau')->first();

        if (!$membre) {
            return response()->json(['success' => true, 'membre' => false]);
        }

        $historique = HistoriquePoint::where('user_id', $userId)
            ->orderByDesc('created_at')->take(10)
            ->get()->map(fn($h) => [
                'points' => $h->points,
                'motif'  => $h->motif,
                'date'   => $h->created_at->format('d/m/Y'),
            ]);

        return response()->json([
            'success'        => true,
            'membre'         => true,
            'points_total'   => $membre->points_total,
            'niveau'         => $membre->niveau->nom,
            'reduction_pct'  => (float) $membre->niveau->reduction_pct,
            'date_adhesion'  => $membre->date_adhesion?->format('d/m/Y'),
            'historique'     => $historique,
        ]);
    }
}
