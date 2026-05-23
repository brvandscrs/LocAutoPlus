<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HistoriquePoint;
use App\Models\ClubMembre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientApiController extends Controller
{
    public function index()
    {
        $clients = User::withCount('contrats')
            ->with(['clubMembre.niveau'])
            ->orderBy('nom')
            ->get()
            ->map(fn($u) => $this->formatClient($u));

        return response()->json(['success' => true, 'data' => $clients]);
    }

    public function show($id)
    {
        $user = User::withCount('contrats')
            ->with(['clubMembre.niveau'])
            ->findOrFail($id);

        return response()->json(['success' => true, 'data' => $this->formatClient($user)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'telephone'      => 'nullable|string|max:20',
            'adresse'        => 'nullable|string',
            'date_naissance' => 'nullable|date',
        ]);

        $user = User::create([
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'telephone'      => $request->telephone,
            'adresse'        => $request->adresse,
            'date_naissance' => $request->date_naissance,
        ]);

        return response()->json(['success' => true, 'data' => $this->formatClient($user)], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nom'            => 'required|string|max:255',
            'prenom'         => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $id,
            'telephone'      => 'nullable|string|max:20',
            'adresse'        => 'nullable|string',
            'date_naissance' => 'nullable|date',
        ]);

        $user->update([
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'email'          => $request->email,
            'telephone'      => $request->telephone,
            'adresse'        => $request->adresse,
            'date_naissance' => $request->date_naissance,
        ]);

        return response()->json(['success' => true, 'data' => $this->formatClient($user->fresh())]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->contrats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer ce client : il possède ' . $user->contrats()->count() . ' contrat(s).',
            ], 422);
        }

        HistoriquePoint::where('user_id', $id)->delete();
        ClubMembre::where('user_id', $id)->delete();
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Client supprimé.']);
    }

    private function formatClient(User $u): array
    {
        return [
            'id'             => $u->id,
            'nom'            => $u->nom,
            'prenom'         => $u->prenom,
            'email'          => $u->email,
            'telephone'      => $u->telephone ?? '—',
            'adresse'        => $u->adresse ?? '—',
            'date_naissance' => $u->date_naissance?->format('d/m/Y') ?? '—',
            'date_inscription'=> $u->created_at->format('d/m/Y'),
            'nb_contrats'    => $u->contrats_count ?? $u->contrats()->count(),
            'club_actif'     => $u->clubMembre?->actif ?? false,
            'niveau_club'    => $u->clubMembre?->niveau?->nom,
            'points_club'    => $u->clubMembre?->points_total ?? 0,
        ];
    }
}
