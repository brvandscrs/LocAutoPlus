<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeApiController extends Controller
{
    // Vérifie que l'employé connecté est admin
    private function checkAdmin(Request $request): bool
    {
        return $request->user()?->role === 'admin';
    }

    public function index(Request $request)
    {
        if (!$this->checkAdmin($request)) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $employes = Employe::orderBy('nom')->get()->map(fn($e) => $this->formatEmploye($e));
        return response()->json(['success' => true, 'data' => $employes]);
    }

    public function store(Request $request)
    {
        if (!$this->checkAdmin($request)) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'nom'      => 'required|string|max:255',
            'prenom'   => 'required|string|max:255',
            'email'    => 'required|email|unique:employes,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:agent,admin',
        ]);

        $employe = Employe::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'actif'    => true,
        ]);

        return response()->json(['success' => true, 'data' => $this->formatEmploye($employe)], 201);
    }

    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin($request)) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $employe = Employe::findOrFail($id);

        $request->validate([
            'nom'      => 'required|string|max:255',
            'prenom'   => 'required|string|max:255',
            'email'    => 'required|email|unique:employes,email,' . $id,
            'role'     => 'required|in:agent,admin',
            'password' => 'nullable|min:8',
        ]);

        $data = [
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
            'role'   => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employe->update($data);
        return response()->json(['success' => true, 'data' => $this->formatEmploye($employe->fresh())]);
    }

    public function toggleActif(Request $request, $id)
    {
        if (!$this->checkAdmin($request)) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $employe = Employe::findOrFail($id);

        if ($employe->email === $request->user()->email) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de modifier son propre statut.',
            ], 422);
        }

        $employe->update(['actif' => !$employe->actif]);

        return response()->json([
            'success' => true,
            'actif'   => $employe->actif,
            'message' => $employe->actif ? 'Compte activé.' : 'Compte désactivé.',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if (!$this->checkAdmin($request)) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $employe = Employe::findOrFail($id);

        if ($employe->email === $request->user()->email) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer son propre compte.',
            ], 422);
        }

        $employe->delete();
        return response()->json(['success' => true, 'message' => 'Employé supprimé.']);
    }

    private function formatEmploye(Employe $e): array
    {
        return [
            'id'            => $e->id,
            'nom'           => $e->nom,
            'prenom'        => $e->prenom,
            'email'         => $e->email,
            'role'          => $e->role,
            'actif'         => $e->actif,
            'date_creation' => $e->created_at->format('d/m/Y'),
        ];
    }
}
