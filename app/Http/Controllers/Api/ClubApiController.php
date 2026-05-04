<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClubMembre;
use App\Models\NiveauClub;
use Illuminate\Http\Request;

class ClubApiController extends Controller
{
    public function verifier($userId)
    {
        $membre = ClubMembre::where('user_id', $userId)
            ->with('niveau')
            ->first();

        if (!$membre) {
            return response()->json([
                'success'  => false,
                'message'  => 'Client non membre du Club.',
                'membre'   => false,
            ]);
        }

        return response()->json([
            'success'       => true,
            'membre'        => true,
            'points_total'  => $membre->points_total,
            'niveau'        => $membre->niveau->nom,
            'reduction_pct' => $membre->niveau->reduction_pct,
            'date_adhesion' => $membre->date_adhesion,
        ]);
    }
}
