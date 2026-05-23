<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicule::with('categorie')->orderBy('marque');

        if ($request->filled('statut') && $request->statut !== 'Tous')
            $query->where('statut', $request->statut);

        if ($request->filled('search'))
            $query->where(function($q) use ($request) {
                $q->where('marque', 'like', '%' . $request->search . '%')
                  ->orWhere('modele', 'like', '%' . $request->search . '%')
                  ->orWhere('immatriculation', 'like', '%' . $request->search . '%');
            });

        $vehicules = $query->get()->map(fn($v) => $this->formatVehicule($v));
        return response()->json(['success' => true, 'data' => $vehicules]);
    }

    public function show($id)
    {
        $v = Vehicule::with('categorie')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $this->formatVehicule($v)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'immatriculation' => 'required|string|unique:vehicules,immatriculation',
            'marque'          => 'required|string',
            'modele'          => 'required|string',
            'annee'           => 'required|integer|min:1900|max:2100',
            'categorie_id'    => 'required|exists:categories_vehicules,id',
            'km_actuel'       => 'nullable|integer|min:0',
            'statut'          => 'nullable|in:disponible,loue,maintenance,hors_service',
            'photo_url'       => 'nullable|string',
        ]);

        $v = Vehicule::create([
            'immatriculation' => strtoupper($request->immatriculation),
            'marque'          => $request->marque,
            'modele'          => $request->modele,
            'annee'           => $request->annee,
            'categorie_id'    => $request->categorie_id,
            'km_actuel'       => $request->km_actuel ?? 0,
            'statut'          => $request->statut ?? 'disponible',
            'photo_url'       => $request->photo_url,
        ]);

        return response()->json(['success' => true, 'data' => $this->formatVehicule($v->load('categorie'))], 201);
    }

    public function update(Request $request, $id)
    {
        $v = Vehicule::findOrFail($id);

        $request->validate([
            'marque'       => 'required|string',
            'modele'       => 'required|string',
            'annee'        => 'required|integer|min:1900|max:2100',
            'categorie_id' => 'required|exists:categories_vehicules,id',
            'km_actuel'    => 'nullable|integer|min:0',
            'statut'       => 'nullable|in:disponible,loue,maintenance,hors_service',
            'photo_url'    => 'nullable|string',
        ]);

        $v->update($request->only([
            'marque','modele','annee','categorie_id',
            'km_actuel','statut','photo_url'
        ]));

        return response()->json(['success' => true, 'data' => $this->formatVehicule($v->fresh()->load('categorie'))]);
    }

    public function destroy($id)
    {
        $v = Vehicule::findOrFail($id);

        if ($v->statut === 'loue') {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer un véhicule actuellement loué.',
            ], 422);
        }

        $v->delete();
        return response()->json(['success' => true, 'message' => 'Véhicule supprimé.']);
    }

    private function formatVehicule(Vehicule $v): array
    {
        return [
            'id'              => $v->id,
            'immatriculation' => $v->immatriculation,
            'marque'          => $v->marque,
            'modele'          => $v->modele,
            'annee'           => $v->annee,
            'km_actuel'       => $v->km_actuel,
            'statut'          => $v->statut,
            'photo_url'       => $v->photo_url,
            'categorie'       => $v->categorie?->nom,
            'categorie_id'    => $v->categorie_id,
            'tarif_jour'      => (float) $v->categorie?->tarif_base_jour,
        ];
    }
}
