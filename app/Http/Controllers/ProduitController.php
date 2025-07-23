<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProduitController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  Récupérer l'utilisateur connecté
        $user = Auth::user();

        // S'assurer que l'utilisateur est bien un entrepreneur approuvé
        if ($user->role !== 'entrepreneur_approuve') {
            // Optionnel : rediriger avec une erreur si un admin ou autre essaie d'accéder
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }
        // Vérifier si l'utilisateur a un stand
        if (!$user->stand) {
            return redirect()->route('dashboard')->with('error', 'Vous devez d\'abord créer un stand.');
        }

        // Récupérer les produits via les relations définies !
        // User -> a un Stand -> qui a plusieurs Produits
        $produits = $user->stand->produits;

        // Envoyer les produits à la vue
        return view('produits.index', ['produits' => $produits]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'entrepreneur_approuve') {
        abort(403, 'Accès non autorisé.');
        }

        return view('produits.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
    ]);

    // Récupération de l'utilisateur et de son stand
    $user = Auth::user();
    $stand = $user->stand;
    
    // vérifie que le stand existe bien
    if (!$stand) {
        return redirect()->route('dashboard')->with('error', 'Erreur : Stand non trouvé.');
    }
    
    // ajout de l'ID du stand aux données validées pour la création
    $validatedData['stand_id'] = $stand->id;

    // Gestion de l'upload de l'image 
    if ($request->hasFile('image')) {
        // 'produits' est le nom du dossier dans storage/app/public
        $path = $request->file('image')->store('produits', 'public');
        // On stocke le chemin d'accès dans la base de données
        $validatedData['image_url'] = $path;
    }

    // Création du produit
    Produit::create($validatedData);

    // Redirection avec un message de succès
    return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        // verifier que le produit appartient au stand de l'utilisateur connecté
        if (Auth::user()->stand->id !== $produit->stand_id) {
        abort(403, 'Action non autorisée.');
    }

    return view('produits.show', ['produit' => $produit]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        // Sécurité : On vérifie que le produit appartient bien au stand de l'utilisateur connecté
    if (Auth::user()->stand->id !== $produit->stand_id) {
        abort(403);
    }

    return view('produits.edit', ['produit' => $produit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        if (Auth::user()->stand->id !== $produit->stand_id) {
        abort(403);
    }

    // Validation des données 
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // Gestion de la nouvelle image, si elle est fournie
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image pour ne pas encombrer le serveur
        if ($produit->image_url) {
            Storage::disk('public')->delete($produit->image_url);
        }
        // Stocker la nouvelle image
        $path = $request->file('image')->store('produits', 'public');
        $validatedData['image_url'] = $path;
    }

    // Mise à jour du produit avec les nouvelles données
    $produit->update($validatedData);

    return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
         if (Auth::user()->stand->id !== $produit->stand_id) {
        abort(403);
    }

    // Supprimer l'image associée du stockage
    if ($produit->image_url) {
        Storage::disk('public')->delete($produit->image_url);
    }

    // Supprimer le produit de la base de données
    $produit->delete();

    return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}
