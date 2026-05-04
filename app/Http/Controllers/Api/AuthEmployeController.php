<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthEmployeController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $employe = Employe::where('email', $request->email)
                          ->where('actif', true)
                          ->first();

        if (!$employe || !Hash::check($request->password, $employe->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants incorrects ou compte inactif.',
            ], 401);
        }

        $token = $employe->createToken('locautoplus-desktop')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'employe' => [
                'id'     => $employe->id,
                'nom'    => $employe->nom,
                'prenom' => $employe->prenom,
                'email'  => $employe->email,
                'role'   => $employe->role,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true, 'message' => 'Déconnecté.']);
    }
}
