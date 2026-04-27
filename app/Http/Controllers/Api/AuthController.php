<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        // Validation des données d'entrée
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Vérification si l'utilisateur existe
        $user = User::where('email', $request->email)->first();
        if ($user) {
            // Ici, le user existe, 
//            if ($user->is_admin) {
                // Si l'utilisateur est un admin, on vérifie le mot de passe
                if (password_verify($request->password, $user->password)) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                } else {
                    return response()->json(['message' => 'Identifiants incorrects'], 401);
                }
//            } else {
//                return response()->json(['message' => 'Identifiants incorrects'], 401);
//            }
        } else {
            return response()->json(['message' => 'Identifiants incorrects'], 401);
        }
    } 
}
