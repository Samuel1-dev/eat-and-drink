{{-- resources/views/public/stands-list.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    .stands-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; }
    .stand-card {
        background-color: var(--dark-card-bg); border: 1px solid var(--dark-border);
        border-radius: 8px; overflow: hidden; text-decoration: none; color: inherit;
        display: block; transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stand-card:hover { transform: scale(1.03); box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
    .stand-card .card-banner {
        height: 150px; background-color: var(--accent-blue); color: white;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; font-weight: bold; text-align: center; padding: 15px;
    }
    .stand-card .card-content { padding: 20px; }
    .stand-card h3 { margin-top: 0; color: var(--dark-text-primary); }
    .stand-card p { color: var(--dark-text-secondary); }
</style>

<h1 class="mb-4" style="text-align:center; font-size: 2.5rem; margin-bottom: 40px;">Découvrez Nos Exposants</h1>

@if($stands->isEmpty())
    <div style="background-color: var(--dark-card-bg); padding: 30px; border-radius: 8px; text-align: center;">
        <h3>Aucun exposant n'est disponible pour le moment.</h3>
        <p>Revenez bientôt pour découvrir nos artisans !</p>
    </div>
@else
    <div class="stands-grid">
        @foreach($stands as $stand)
            <a href="{{ route('stands.show', $stand) }}" class="stand-card">
                <div class="card-banner">
                    {{ $stand->nom_stand }}
                </div>
                <div class="card-content">
                    <h3>Par {{ $stand->user->nom_entreprise }}</h3>
                    <p>{{ Str::limit($stand->description, 100) }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection