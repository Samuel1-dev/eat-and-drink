@extends('layouts.app')

@section('content')
    
    <div style="background-color: var(--dark-card-bg); padding: 30px; border-radius: 8px;">
        
        <h2 style="margin-top: 0;">Tableau de Bord</h2>

        <p>
            Bonjour entreprise **{{ Auth::user()->nom_entreprise }}**, bienvenue !
        </p>

        {{-- === VUE POUR L'ENTREPRENEUR EN ATTENTE === --}}
        @if(Auth::user()->role == 'entrepreneur_en_attente')
            <div style="background-color: #e67e22; color: white; padding: 15px; border-radius: 5px; text-align: center;">
                <h3>Votre demande est en cours de validation</h3>
                <p>Un administrateur examinera votre profil sous peu. Vous n'avez accès à aucune autre fonctionnalité pour le moment.</p>
            </div>
        
        {{-- === VUE POUR L'ENTREPRENEUR APPROUVÉ === --}}
        @elseif(Auth::user()->role == 'entrepreneur_approuve')
            <div style="background-color: #27ae60; color: white; padding: 15px; border-radius: 5px;">
                Félicitations ! Votre demande a été approuvée. Vous pouvez maintenant commencer à gérer vos produits.
            </div>
                <h3 style="margin-top: 20px;">
                    <a href="{{ route('produits.index') }}" style="background-color: white; color: #27ae60; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Gérer Mes Produits
                    </a>
                </h3>
             </div>
        {{-- === VUE POUR L'ADMINISTRATEUR === --}}
        @elseif(Auth::user()->role == 'admin')
            <h3>Demandes de Stand en Attente d'Approbation</h3>
            
            @if($pendingUsers->isEmpty())
                <p>Il n'y a aucune nouvelle demande pour le moment.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="text-align: left; border-bottom: 1px solid var(--dark-border);">
                        <tr>
                            <th style="padding: 10px;">Nom de l'Entreprise</th>
                            <th style="padding: 10px;">Email</th>
                            <th style="padding: 10px;">Date d'inscription</th>
                            <th style="padding: 10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingUsers as $pendingUser)
                            <tr style="border-bottom: 1px solid var(--dark-border);">
                                <td style="padding: 10px;">{{ $pendingUser->nom_entreprise }}</td>
                                <td style="padding: 10px;">{{ $pendingUser->email }}</td>
                                <td style="padding: 10px;">{{ $pendingUser->created_at->format('d/m/Y') }}</td>
                                <td style="padding: 10px;">
                                    <form action="{{ route('admin.approve', $pendingUser) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" style="background-color: var(--accent-blue); color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;">
                                            Approuver
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif
    </div>

@endsection