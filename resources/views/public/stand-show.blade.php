@extends('layouts.app')

@section('content')
<style>
    .stand-header { text-align: center; margin-bottom: 40px; padding: 30px; background: var(--dark-card-bg); border-radius: 8px; }
    .stand-header h1 { margin-top: 0; font-size: 3rem; }
    .stand-header p { font-size: 1.2rem; color: var(--dark-text-secondary); max-width: 700px; margin: auto;}
    .produits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .produit-card {
        background-color: var(--dark-card-bg);
        border: 1px solid var(--dark-border);
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
       
    }

    .produit-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }
    
    .produit-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: var(--dark-border);
    }

    .card-content {
        padding: 20px;
        flex-grow: 1; /* Pousse les actions en bas */
    }
    
    .card-content h3 {
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 1.4rem;
        color: var(--dark-text-primary);
    }

    .card-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--accent-blue);
    }

    .card-actions {
        padding: 0 20px 20px 20px;
    }
    
    /* Style Spécifique pour le Bouton Panier */
    .btn-add-cart {
        width: 100%;
        text-align: center;
        padding: 12px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        background-color: var(--accent-blue);
        color: white;
        border: none;
        font-size: 1rem;
        transition: background-color 0.3s;
    }
    .btn-add-cart:hover {
        background-color: var(--accent-blue-hover);
    }
     .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: var(--accent-blue);
        text-decoration: none;
        font-weight: bold;
    }
</style>
<a href="{{ route('stands.index') }}" class="back-link">← Retour à la liste des exposants</a>
<div class="stand-header">
    <h1>{{ $stand->nom_stand }}</h1>
    <p>{{ $stand->description }}</p>
</div>

<h2 style="margin-bottom: 20px;">Nos Produits</h2>

@if($stand->produits->isEmpty())
    <div style="background-color: var(--dark-card-bg); padding: 30px; border-radius: 8px; text-align: center;">
        <h3>Ce stand n'a pas encore de produits à proposer.</h3>
        <p>Revenez un peu plus tard !</p>
    </div>
@else
    <div class="produits-grid">
        @foreach($stand->produits as $produit)
            <div class="produit-card">
                <div>
                    @if($produit->image_url)
                        <img src="{{ asset('storage/' . $produit->image_url) }}" alt="Image de {{ $produit->nom }}">
                    @else
                        <img src="https://via.placeholder.com/300x200.png?text=Image+non+disponible" alt="Image non disponible">
                    @endif

                    <div class="card-content">
                        <h3>{{ $produit->nom }}</h3>
                        <p class="card-price">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</p>
                    </div>
                </div>

                <div class="card-actions">
                        <form action="{{ route('cart.add', $produit) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-add-cart">Ajouter au Panier</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection