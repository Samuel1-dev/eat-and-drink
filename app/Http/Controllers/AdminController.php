<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stand;

class AdminController extends Controller
{
    public function approve(User $user)
    {
        // Changer le rôle de l'utilisateur
        $user->role = 'entrepreneur_approuve';
        $user->save();

        // Créer un stand pour cet utilisateur
        // On utilise le nom de l'entreprise comme nom de stand par défaut
        Stand::create([
            'nom_stand' => $user->nom_entreprise,
            'description' => 'Bienvenue sur notre stand !',
            'user_id' => $user->id,
        ]);

        // Rediriger l'admin vers le tableau de bord avec un message de succès
        return redirect()->route('dashboard')->with('success', 'L\'entrepreneur a été approuvé avec succès !');
    }
}