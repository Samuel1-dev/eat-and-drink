@extends('layouts.app')

@section('content')
<style>
    .cart-item { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid var(--dark-border); }
    .cart-item img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; margin-right: 15px; }
    .item-details { flex-grow: 1; }
    .item-actions { display: flex; align-items: center; }
    .item-actions input { width: 50px; text-align: center; margin: 0 10px; }
    .cart-summary { margin-top: 30px; background-color: var(--dark-card-bg); padding: 20px; border-radius: 8px; text-align: right; }
    .cart-total { font-size: 1.8rem; font-weight: bold; }
    .btn-checkout { background-color: #27ae60; color: white; padding: 15px 30px; font-size: 1.2rem; border-radius: 5px; border: none; cursor: pointer; margin-top: 15px; }
</style>

<h1>Mon Panier</h1>

@if(empty($cart))
    <p>Votre panier est vide.</p>
@else
    <div class="cart-container">
        @foreach($cart as $id => $details)
            <div class="cart-item">
                <img src="{{ $details['image_url'] ? asset('storage/' . $details['image_url']) : 'https://via.placeholder.com/80' }}" alt="{{ $details['nom'] }}">
                <div class="item-details">
                    <h4 style="margin: 0;">{{ $details['nom'] }}</h4>
                    <span>{{ number_format($details['prix'], 2, ',', ' ') }} FCFA</span>
                </div>
                <div class="item-actions">
                    <form action="{{ route('cart.update', $id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1">
                        <button type="submit">Mettre à jour</button>
                    </form>
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit" style="color:var(--danger-red); background: none; border: none; font-size: 1.5rem; cursor: pointer;">×</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="cart-summary">
        <div class="cart-total">
            Total : {{ number_format($total, 2, ',', ' ') }} FCFA
        </div>
        <form action="{{ route('order.place') }}" method="POST">
            @csrf
            <button type="submit" class="btn-checkout">Valider la commande</button>
        </form>
    </div>
@endif
@endsection