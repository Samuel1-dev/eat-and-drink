@extends('layouts.app')

@section('content')
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

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: var(--accent-blue);
        text-decoration: none;
        font-weight: bold;
    }
</style>
<a href="{{ route('produits.index') }}" class="back-link">← Retour à la liste de mes produits</a>

<div class="form-container">
    <h2 style="margin-top: 0;">Ajouter un nouveau produit</h2>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Le formulaire doit avoir cet enctype pour pouvoir envoyer des fichiers --}}
    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="nom">Nom du produit</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="prix">Prix (en FCFA)</label>
            <input type="number" id="prix" name="prix" step="0.01" min="0" value="{{ old('prix') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Photo du produit</label>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp">
        </div>

        <button type="submit" class="btn-submit">Enregistrer le Produit</button>
    </form>
</div>
@endsection