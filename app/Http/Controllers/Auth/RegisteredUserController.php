<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create()
    {
        
        return view('auth.register');
    }
    
    /**
     * Gère une demande d'inscription.
     */
    public function store(Request $request)
    {

        // Validation des données
        $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'nom_entreprise' => $request->nom_entreprise,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        // Connexion de l'utilisateur
        Auth::login($user);

        //  Redirection
        return redirect()->route('dashboard'); 
    }
}