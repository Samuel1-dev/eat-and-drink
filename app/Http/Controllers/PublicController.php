<?php

namespace App\Http\Controllers;

use App\Models\Stand;

class PublicController extends Controller
{
    /**
     * Affiche la liste de tous les stands approuvés.
     */
    public function listStands()
    {
        // On récupère les stands SEULEMENT si leur propriétaire (user) a le rôle 'entrepreneur_approuve'.
        $stands = Stand::whereHas('user', function ($query) {
            $query->where('role', 'entrepreneur_approuve');
        })->with('user')->get(); 

        return view('public.stands-list', ['stands' => $stands]);
    }

    /**
     * Affiche la page dédiée d'un stand avec ses produits.
     */
    public function showStand(Stand $stand)
    {
        // On s'assure que l'on ne peut afficher que les stands approuvés
        if ($stand->user->role !== 'entrepreneur_approuve') {
            abort(404); 
        }

        // On charge les produits du stand
        $stand->load('produits');

        return view('public.stand-show', ['stand' => $stand]);
    }
}