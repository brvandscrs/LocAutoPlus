<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request) : View
    {
        $datedebut = $request->datedebut;
        $datefin = $request->datefin;
        return view('reservation.index', compact('datedebut', 'datefin'));
    }
}
