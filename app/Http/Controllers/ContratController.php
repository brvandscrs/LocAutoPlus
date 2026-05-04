<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContratController extends Controller
{
    public function index()
    {
        $contrats = Contrat::where('user_id', Auth::id())
            ->with('vehicule.categorie')
            ->orderBy('date_reservation', 'desc')
            ->get();

        return view('contrats.index', compact('contrats'));
    }

    public function show($id)
    {
        $contrat = Contrat::where('user_id', Auth::id())
            ->with(['vehicule.categorie', 'employe'])
            ->findOrFail($id);

        return view('contrats.show', compact('contrat'));
    }
}
