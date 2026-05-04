@extends('layouts.app')
@section('title', $vehicule->marque . ' ' . $vehicule->modele)

@section('content')
<style>
    .back-link { color: var(--gris); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.4rem; margin-bottom: 1.5rem; }
    .back-link:hover { color: var(--noir); }
    .vehicule-layout { display: grid; grid-template-columns: 1fr 380px; gap: 2rem; align-items: start; }
    @media(max-width: 768px) { .vehicule-layout { grid-template-columns: 1fr; } }
    .vehicule-visuel { background: var(--creme); border-radius: 16px; height: 300px; display: flex; align-items: center; justify-content: center; font-size: 6rem; }
    .vehicule-infos h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 0.5rem; }
    .vehicule-infos .cat { color: var(--gris); margin-bottom: 1.5rem; }
    .specs { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1.5rem 0; }
    .spec { background: var(--creme); border-radius: 10px; padding: 1rem; }
    .spec-label { font-size: 0.78rem; color: var(--gris); margin-bottom: 0.25rem; }
    .spec-value { font-weight: 500; font-size: 1rem; }
    .reservation-card { background: white; border: 1.5px solid var(--gris-lgt); border-radius: 16px; padding: 1.75rem; position: sticky; top: 80px; }
    .reservation-card .prix { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 0.25rem; }
    .reservation-card .prix small { font-family: 'DM Sans', sans-serif; font-size: 0.85rem; color: var(--gris); }
    .club-notice { background: #fffbeb; border: 1px solid var(--or-clair); border-radius: 8px; padding: 0.75rem 1rem; font-size: 0.85rem; color: #92680a; margin: 1rem 0; }
</style>

<a href="{{ route('vehicules.index') }}" class="back-link">← Retour au catalogue</a>

<div class="vehicule-layout">
    <div>
        <div class="vehicule-visuel">🚗</div>
        <div class="vehicule-infos" style="margin-top:1.5rem">
            <h1>{{ $vehicule->marque }} {{ $vehicule->modele }}</h1>
            <div class="cat">{{ $vehicule->categorie->nom }} · {{ $vehicule->annee }}</div>
            <span class="badge badge-dispo">Disponible à la location</span>
            <div class="specs">
                <div class="spec">
                    <div class="spec-label">Immatriculation</div>
                    <div class="spec-value">{{ $vehicule->immatriculation }}</div>
                </div>
                <div class="spec">
                    <div class="spec-label">Kilométrage</div>
                    <div class="spec-value">{{ number_format($vehicule->km_actuel) }} km</div>
                </div>
                <div class="spec">
                    <div class="spec-label">Catégorie</div>
                    <div class="spec-value">{{ $vehicule->categorie->nom }}</div>
                </div>
                <div class="spec">
                    <div class="spec-label">Tarif journalier</div>
                    <div class="spec-value">{{ number_format($vehicule->categorie->tarif_base_jour, 2, ',', ' ') }} €</div>
                </div>
            </div>
            @if($vehicule->categorie->description)
                <p style="color:var(--gris);line-height:1.7">{{ $vehicule->categorie->description }}</p>
            @endif
        </div>
    </div>

    <div class="reservation-card">
        <div class="prix">{{ number_format($vehicule->categorie->tarif_base_jour, 2, ',', ' ') }} € <small>/ jour</small></div>

        @auth
            @if(auth()->user()->clubMembre)
                <div class="club-notice">
                    ⭐ Membre Club — {{ auth()->user()->clubMembre->niveau->reduction_pct }}% de réduction appliqués
                </div>
            @endif
            <a href="{{ route('reservation.show', $vehicule->id) }}" class="btn btn-gold" style="width:100%;text-align:center;padding:0.9rem;margin-top:0.5rem">
                Réserver ce véhicule
            </a>
        @else
            <p style="color:var(--gris);font-size:0.9rem;margin:1rem 0">Connectez-vous pour réserver ce véhicule.</p>
            <a href="{{ route('login') }}" class="btn btn-primary" style="width:100%;text-align:center;padding:0.9rem">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-outline" style="width:100%;text-align:center;padding:0.9rem;margin-top:0.75rem">Créer un compte</a>
        @endauth
    </div>
</div>
@endsection
