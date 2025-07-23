{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eat&Drink</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark-bg: #18191a; --dark-card-bg: #242526; --dark-text-primary: #e4e6eb;
            --dark-text-secondary: #b0b3b8; --dark-border: #3a3b3c; --accent-blue: #2374e1;
            --accent-blue-hover: #1b66ca; --danger-red: #e74c3c;
        }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: var(--dark-bg); color: var(--dark-text-primary); }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }
        .main-header { background-color: var(--dark-card-bg); border-bottom: 1px solid var(--dark-border); padding: 1rem 0; }
        .main-nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: 700; color: var(--dark-text-primary); text-decoration: none; }
        .nav-links { display: flex; align-items: center; }
        .nav-links a, .nav-links form button {
            color: var(--dark-text-primary); text-decoration: none; padding: 0.5rem 1rem; margin-left: 0.5rem;
            border-radius: 6px; font-weight: 600; transition: background-color 0.3s, color 0.3s;
            background: none; border: none; font-size: 1rem; font-family: 'Poppins', sans-serif; cursor: pointer;
        }
        .nav-links a.btn, .nav-links form button.btn {
            border: 1px solid var(--accent-blue);
        }
        .nav-links a.btn-primary, .nav-links form button.btn-primary {
            background-color: var(--accent-blue); color: white;
        }
        .nav-links a:hover, .nav-links form button:hover {
             background-color: var(--accent-blue-hover); border-color: var(--accent-blue-hover); color: white;
        }
        .nav-links form { margin: 0; } /* Reset form margin */

        .alert-success {
            background-color: var(--success-green);
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="container">
            <nav class="main-nav">
                <a href="/" class="logo">Eat&Drink</a>
                <div class="nav-links">
                     <a href="{{ route('stands.index') }}">Nos Exposants</a>
                    
                     <a href="{{ route('cart.show') }}" style="position: relative; margin-left: 15px;">
                        🛒
                        @if(Session::has('cart') && count(Session::get('cart')) > 0)
                            <span style="position: absolute; top: -10px; right: -10px; background-color: var(--danger-red); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem;">
                                {{ count(Session::get('cart')) }}
                            </span>
                        @endif
                    </a>

                    {{-- Affiché seulement si l'utilisateur N'EST PAS connecté --}}
                    @guest
                        <a href="{{ route('login') }}" class="btn">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
                    @endguest

                    {{-- Affiché seulement si l'utilisateur EST connecté --}}
                    @auth
                        <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        
                        {{-- Le bouton de déconnexion doit être dans un formulaire POST --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="color: var(--danger-red);">Déconnexion</button>
                        </form>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main class="container" style="padding-top: 40px; padding-bottom: 40px;">
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
    <div class="alert-danger"> 
        {{ session('error') }}
    </div>
@endif
        @yield('content')
    </main>

</body>
</html>