<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère tous les contrats, triés par le plus récent
        $contrats = Contrat::latest()->get(); 

        // Passe les contrats à la vue 'contrats.index'
        return view('contrat.index', compact('contrats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Afficher le formulaire de création
    public function create()
    {
        return view('contrat.create');
    }

    // Gérer la soumission du formulaire et sauvegarder
    public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant' => 'required|numeric|min:0',
            'etat_contrat' => 'required|string|max:255',
        ]);
        
        // 2. Création du contrat (ajoutez l'user_id)
        Contrat::create([
            'user_id' => auth()->id(), // Assurez-vous que l'utilisateur est authentifié
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'montant' => $request->montant,
            'etat_contrat' => $request->etat_contrat,
        ]);

        // 3. Redirection avec un message de succès
        return redirect()->route('contrats.index')
                        ->with('success', 'Contrat créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Showing contrat with ID: " . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Afficher le formulaire de modification
    public function edit(Contrat $contrat)
    {
        // Retourne la vue 'contrat.edit' avec le contrat à modifier
        return view('contrat.edit', compact('contrat'));
    }

    // Gérer la soumission du formulaire et mettre à jour
    public function update(Request $request, Contrat $contrat)
    {
        // 1. Validation (similaire à 'store')
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant' => 'required|numeric|min:0',
            'etat_contrat' => 'required|string|max:255',
        ]);

        // 2. Mise à jour des données
        $contrat->update($request->all());

        // 3. Redirection
        return redirect()->route('contrats.index')
                        ->with('success', 'Contrat mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Supprimer le contrat
    public function destroy(Contrat $contrat)
    {
        $contrat->delete();

        // Redirection
        return redirect()->route('contrats.index')
                        ->with('success', 'Contrat supprimé avec succès.');
    }
}
