<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Ajoute un produit au panier (stocké en session).
     */
    public function add(Request $request, Produit $produit)
    {
        // On récupère le panier actuel depuis la session, ou un tableau vide s'il n'existe pas
        $cart = Session::get('cart', []);
        $produitId = $produit->id;

        // Si le produit est déjà dans le panier, on incrémente la quantité
        if (isset($cart[$produitId])) {
            $cart[$produitId]['quantity']++;
        } else {
            // Sinon, on l'ajoute avec les informations nécessaires
            $cart[$produitId] = [
                "nom" => $produit->nom,
                "quantity" => 1,
                "prix" => $produit->prix,
                "image_url" => $produit->image_url,
                "stand_id" => $produit->stand_id // Important pour la commande finale
            ];
        }

        // On sauvegarde le panier mis à jour dans la session
        Session::put('cart', $cart);

        // On redirige l'utilisateur vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès !');
    }

    public function show()
        {
            $cart = Session::get('cart', []);
            
            $total = 0;
            foreach ($cart as $id => $details) {
                $total += $details['prix'] * $details['quantity'];
            }

            return view('public.cart', compact('cart', 'total'));
        }

        public function remove(Produit $produit)
        {
            $cart = Session::get('cart', []);
            if (isset($cart[$produit->id])) {
                unset($cart[$produit->id]);
                Session::put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Produit retiré du panier.');
        }

        public function update(Request $request, Produit $produit)
        {
            $cart = Session::get('cart', []);
            if (isset($cart[$produit->id])) {
                $cart[$produit->id]['quantity'] = $request->quantity;
                Session::put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Quantité mise à jour.');
        }

        public function placeOrder(Request $request)
        {
            $cart = Session::get('cart', []);
            if (empty($cart)) {
                return redirect()->route('stands.index')->with('error', 'Votre panier est vide.');
            }

            // Important : On groupe les produits par stand_id
            $groupedCart = collect($cart)->groupBy('stand_id');

            // On crée une commande par stand
            foreach ($groupedCart as $stand_id => $items) {
                Commande::create([
                    'stand_id' => $stand_id,
                    'details_commande' => json_encode($items->toArray()), // On stocke les produits en JSON
                ]);
            }

            // On vide le panier
            Session::forget('cart');

            // On redirige avec un message de succès
            return redirect()->route('home')->with('success', 'Votre commande a été passée avec succès ! Merci de votre confiance.');
        }

}