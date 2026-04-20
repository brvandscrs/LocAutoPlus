<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Vehicule;

class ReservationController extends Controller
{
    public function index(Request $request) : View
    {
        $datedebut = $request->datedebut;
        $heuredebut = $request->heuredebut;
        $datefin = $request->datefin;
        $heurefin = $request->heurefin;

        $vehicules = Vehicule::all();

        return view('reservation', compact('vehicules', 'datedebut', 'heuredebut', 'datefin', 'heurefin'));
    }
}
