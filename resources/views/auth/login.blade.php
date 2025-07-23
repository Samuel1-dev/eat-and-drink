@extends('layouts.app')

@section('content')
<style>
    .auth-container { background-color: var(--dark-card-bg); padding: 40px; border-radius: 8px; max-width: 450px; margin: 40px auto; }
    h2 { text-align: center; margin-top:0; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 5px; color: var(--dark-text-secondary); }
    input { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid var(--dark-border); background-color: var(--dark-border); color: var(--dark-text-primary); box-sizing: border-box; }
    button { width: 100%; padding: 12px; background-color: var(--accent-blue); color: white; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; }
    .error { color: #f15454; font-size: 0.9em; margin-top: 5px;}
</style>
<div class="auth-container">
    <h2>Connexion</h2>
    <form method="POST" action="{{ route('authenticate') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>
        <button type="submit">Se connecter</button>
    </form>
</div>
@endsection