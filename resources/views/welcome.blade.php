<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eat&Drink - La plateforme des gourmands</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /* Variables de couleurs pour le thème sombre */
        :root {
            --dark-bg: #18191a;
            --dark-card-bg: #242526;
            --dark-text-primary: #e4e6eb;
            --dark-text-secondary: #b0b3b8;
            --dark-border: #3a3b3c;
            --accent-blue: #2374e1;
            --accent-blue-hover: #1b66ca;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: var(--dark-bg);
            color: var(--dark-text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Header & Navigation --- */
        .main-header {
            background-color: var(--dark-card-bg);
            border-bottom: 1px solid var(--dark-border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-text-primary);
            text-decoration: none;
        }

        .nav-links a {
            color: var(--dark-text-primary);
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            margin-left: 0.5rem;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-links a.btn-login {
            background-color: transparent;
            border: 1px solid var(--accent-blue);
        }
        
        .nav-links a.btn-login:hover {
            background-color: var(--accent-blue);
            color: white;
        }

        .nav-links a.btn-register {
            background-color: var(--accent-blue);
            border: 1px solid var(--accent-blue);
            color: white;
        }

        .nav-links a.btn-register:hover {
            background-color: var(--accent-blue-hover);
            border-color: var(--accent-blue-hover);
        }
        
        /* --- Section Hero --- */
        .hero {
            text-align: center;
            padding: 80px 20px;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--dark-text-secondary);
            max-width: 700px;
            margin: 0 auto;
        }

        /* --- Section des Fonctionnalités --- */
        .features {
            padding: 40px 0 80px 0;
        }
        
        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background-color: var(--dark-card-bg);
            border: 1px solid var(--dark-border);
            padding: 30px;
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-top: 0;
            color: var(--accent-blue);
        }
        
        .feature-card p {
            color: var(--dark-text-secondary);
        }

        /* --- Footer --- */
        .main-footer {
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
            border-top: 1px solid var(--dark-border);
            color: var(--dark-text-secondary);
        }

    </style>
</head>
<body>

    <header class="main-header">
        <div class="container">
            <nav class="main-nav">
                <a href="/" class="logo">Eat&Drink</a>
                <div class="nav-links">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn-login">Connexion</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-register">Inscription</a>
                    @endif
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <h1>Bienvenue sur Eat&Drink</h1>
            <p>La plateforme qui connecte les entrepreneurs culinaires passionnés avec un public de gourmands. Découvrez, commandez et savourez !</p>
        </section>

        <section class="features">
            <div class="container">
                <h2>Le Cœur de Notre Application</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>Gestion des Utilisateurs</h3>
                        <p>Un système de rôles clair : Administrateurs pour la supervision, Entrepreneurs pour la gestion de leur stand, et Visiteurs pour découvrir et commander.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Validation des Stands</h3>
                        <p>Les entrepreneurs peuvent soumettre une demande de stand. Les administrateurs valident ces demandes pour garantir la qualité de notre événement.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Gestion des Produits</h3>
                        <p>Chaque entrepreneur dispose d'un tableau de bord personnel pour ajouter, modifier et présenter ses produits (plats, boissons, etc.) avec photos et descriptions.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Vitrine Publique & Commandes</h3>
                        <p>Le public peut parcourir la liste des exposants, consulter leurs menus, ajouter des produits à un panier et passer commande en toute simplicité.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <p>© {{ date('Y') }} Eat&Drink. Tous droits réservés.</p>
    </footer>

</body>
</html>