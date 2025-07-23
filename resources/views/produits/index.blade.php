@extends('layouts.app')

@section('content')
<style>
    /* NOUVEAU : Le conteneur principal devient la grille */
    .produits-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    /* NOUVEAU : Le header qui contient le titre et le bouton */
    .produits-header {
        /* LA LIGNE MAGIQUE : Fait en sorte que cet élément s'étende sur toutes les colonnes de la grille */
        grid-column: 1 / -1;
        
        /* Le reste est pour aligner le titre et le bouton */
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px; /* Petite marge pour l'aérer des cartes */
    }

    .produits-header h2 {
        margin: 0;
    }

    .btn-ajout {
        background-color: var(--accent-blue);
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

    /* --- Style de la Carte Produit (inchangé) --- */
    .produit-card {
        background-color: var(--dark-card-bg);
        border: 1px solid var(--dark-border);
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .produit-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }
    
    .card-link-wrapper { text-decoration: none; color: inherit; display: block; }
    .produit-card img { width: 100%; height: 200px; object-fit: cover; background-color: var(--dark-border); }
    .card-content { padding: 20px; flex-grow: 1; }
    .card-content h3 { margin-top: 0; margin-bottom: 10px; font-size: 1.4rem; color: var(--dark-text-primary); }
    .card-price { font-size: 1.2rem; font-weight: bold; color: var(--accent-blue); }

    /* --- Section des Boutons d'Action (inchangé) --- */
    .card-actions { padding: 0 20px 20px 20px; display: flex; gap: 10px; }
    .card-actions a, .card-actions button { flex-grow: 1; text-align: center; padding: 10px; border-radius: 5px; text-decoration: none; font-weight: 600; border: 1px solid var(--dark-border); cursor: pointer; }
    .btn-edit { background-color: transparent; color: var(--accent-blue); border-color: var(--accent-blue); }
    .btn-delete { background-color: transparent; color: var(--danger-red); border-color: var(--danger-red); }
    .btn-edit:hover, .btn-delete:hover { color: white; }
    .btn-edit:hover { background-color: var(--accent-blue); }
    .btn-delete:hover { background-color: var(--danger-red); }

</style>

<!-- NOUVEAU : Le conteneur principal qui englobe tout -->
<div class="produits-container">

    <!-- NOUVEAU : Le header est maintenant un élément de la grille -->
    <div class="produits-header">
        <h2>Mes Produits</h2>
        <a href="{{ route('produits.create') }}" class="btn-ajout">Ajouter un Produit</a>
    </div>

    {{-- Si aucun produit n'existe --}}
    @if($produits->isEmpty())
        {{-- NOUVEAU : On applique la même astuce pour que ce message prenne toute la largeur --}}
        <div style="grid-column: 1 / -1; background-color: var(--dark-card-bg); padding: 30px; border-radius: 8px; text-align: center;">
            <h3>Vous n'avez encore aucun produit.</h3>
            <p>Commencez par ajouter votre première spécialité !</p>
        </div>
    @else
        {{-- Les cartes de produits s'insèrent naturellement dans la grille --}}
        @foreach($produits as $produit)
            <div class="produit-card">
                <a href="{{ route('produits.show', $produit) }}" class="card-link-wrapper">
                    @if($produit->image_url)
                        <img src="{{ asset('storage/' . $produit->image_url) }}" alt="Image de {{ $produit->nom }}">
                    @else
                        <img src="https://via.placeholder.com/300x200.png?text=Image+non+disponible" alt="Image non disponible">
                    @endif

                    <div class="card-content">
                        <h3>{{ $produit->nom }}</h3>
                        <p class="card-price">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</p>
                    </div>
                </a>

                <div class="card-actions">
                    <a href="{{route('produits.edit', $produit)}}" class="btn-edit">Modifier</a>
                    <form action="{{-- route('produits.destroy', $produit) --}}" method="POST" style="flex-grow: 1; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" style="width: 100%;" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

</div> 

@endsection