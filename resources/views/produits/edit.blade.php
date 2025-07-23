@extends('layouts.app')

@section('content')
{{-- On peut réutiliser les mêmes styles que pour la création --}}
<style>
    .form-container { background-color: var(--dark-card-bg); padding: 30px; border-radius: 8px; max-width: 700px; margin: auto; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 5px; color: var(--dark-text-secondary); }
    input[type="text"], input[type="number"], textarea {
        width: 100%; padding: 10px; border-radius: 5px; border: 1px solid var(--dark-border);
        background-color: var(--dark-border); color: var(--dark-text-primary); box-sizing: border-box;
    }
    textarea { min-height: 120px; }
    .btn-submit { background-color: var(--accent-blue); color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem; }
    .error-list { list-style-type: none; padding: 0; margin: 15px 0; }
    .error-list li { background-color: #e74c3c; color: white; padding: 10px; border-radius: 4px; margin-bottom: 5px; }
    .current-image { max-width: 200px; margin-top: 10px; border-radius: 5px; }
</style>

<div class="form-container">
    <h2 style="margin-top: 0;">Modifier le produit : {{ $produit->nom }}</h2>

    @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- L'action et la méthode sont différentes ! --}}
    <form action="{{ route('produits.update', $produit) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- On utilise PUT pour la mise à jour --}}
        <div class="form-group">
            <label for="nom">Nom du produit</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $produit->nom) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required>{{ old('description', $produit->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="prix">Prix (en FCFA)</label>
            <input type="number" id="prix" name="prix" step="0.01" min="0" value="{{ old('prix', $produit->prix) }}" required>
        </div>

        <div class="form-group">
            <label for="image">Changer la photo du produit (optionnel)</label>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp">
            @if($produit->image_url)
                <p style="margin-top:10px; color: var(--dark-text-secondary);">Image actuelle :</p>
                <img src="{{ asset('storage/' . $produit->image_url) }}" alt="Image actuelle" class="current-image">
            @endif
        </div>

       <div class="form-actions" style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn-submit" style="flex-grow: 1;">Mettre à jour</button>
            <a href="{{ route('produits.index') }}" class="btn-cancel" style="flex-grow: 1; text-align: center; padding: 12px; background-color: transparent; border: 1px solid var(--dark-border); color: var(--dark-text-secondary); text-decoration: none; border-radius: 5px; font-weight: bold; transition: background-color 0.3s, color 0.3s;">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection