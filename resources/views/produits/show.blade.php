@extends('layouts.app')

@section('content')
<style>
    .produit-detail-container {
        display: grid;
        grid-template-columns: 1fr; /* Une seule colonne par défaut pour mobile */
        gap: 30px;
        background-color: var(--dark-card-bg);
        padding: 30px;
        border-radius: 8px;
    }
    /* Passe à deux colonnes sur les écrans plus larges */
    @media (min-width: 768px) {
        .produit-detail-container {
            grid-template-columns: 1fr 1.5fr;
        }
    }
    .produit-detail-image img {
        width: 100%;
        border-radius: 8px;
        object-fit: cover;
    }
    .produit-detail-info h1 {
        margin-top: 0;
        font-size: 2.5rem;
    }
    .produit-detail-info .prix {
        font-size: 2rem;
        font-weight: bold;
        color: var(--accent-blue);
        margin-bottom: 20px;
    }
    .produit-detail-info .description {
        line-height: 1.7;
        color: var(--dark-text-secondary);
    }
    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: var(--accent-blue);
        text-decoration: none;
        font-weight: bold;
    }
    .back-link:hover { text-decoration: underline; }
</style>

<a href="{{ route('produits.index') }}" class="back-link">← Retour à la liste de mes produits</a>

<div class="produit-detail-container">
    <div class="produit-detail-image">
        @if($produit->image_url)
            <img src="{{ asset('storage/' . $produit->image_url) }}" alt="Image de {{ $produit->nom }}">
        @else
            <img src="https://via.placeholder.com/600x400.png?text=Image+non+disponible" alt="Image non disponible">
        @endif
    </div>
    <div class="produit-detail-info">
        <h1>{{ $produit->nom }}</h1>
        <p class="prix">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</p>
        <div class="description">
            {!! nl2br(e($produit->description)) !!}
        </div>
    </div>
</div>
@endsection