    <?php

    use Illuminate\Support\Facades\Route;
    use App\Models\User;
    use App\Http\Controllers\Auth\RegisteredUserController;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\ProduitController;
    use App\Http\Controllers\PublicController;
    use App\Http\Controllers\CartController;
    // --- Route Publique Principale ---
    // Accessible par tout le monde, connecté ou non.
    Route::get('/', function () {
        return view('welcome');
    })->name('home'); 
        // --- Routes Publiques pour la Vitrine ---
    Route::get('/exposants', [PublicController::class, 'listStands'])->name('stands.index');
    Route::get('/exposants/{stand}', [PublicController::class, 'showStand'])->name('stands.show');


    // --- Routes d'Authentification (pour les Visiteurs) ---
    // Le middleware 'guest' s'assure que seuls les utilisateurs non connectés peuvent accéder à ces pages (ex: on ne peut pas voir la page de login si on est déjà connecté).
    
    Route::middleware('guest')->group(function () {
        // Page d'inscription (formulaire)
        Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

        // Traitement de la soumission du formulaire d'inscription
        Route::post('register', [RegisteredUserController::class, 'store']);

        // Page de connexion (formulaire)
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

        // Traitement de la soumission du formulaire de connexion
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('authenticate');
    });


    // --- Routes Protégées (pour les Utilisateurs Connectés) ---
    // Le middleware 'auth' garantit que seul un utilisateur authentifié
    // peut accéder à ces routes.
    Route::middleware('auth')->group(function () {
        // Tableau de bord
        Route::get('/dashboard', function () {
            $user = Auth::user();
            $pendingUsers = [];

            // Si l'utilisateur connecté est un admin, on récupère les demandes en attente
            if ($user->role === 'admin') {
                $pendingUsers = User::where('role', 'entrepreneur_en_attente')->get();
            }

            return view('dashboard', [
                'pendingUsers' => $pendingUsers,
            ]);
        })->name('dashboard');
        // Route pour approuver un utilisateur
        Route::patch('/admin/users/{user}/approve', [AdminController::class, 'approve'])
        ->name('admin.approve');

         Route::resource('produits', ProduitController::class);
        // Déconnexion
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        // Nous ajouterons ici plus tard les routes pour gérer les produits, etc.
    });

    // --- Routes pour la Gestion du Panier ---
    Route::post('/cart/add/{produit}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/remove/{produit}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{produit}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/order/place', [CartController::class, 'placeOrder'])->name('order.place');
