@extends('layouts.app')
@section('title', 'Mon espace')

@section('content')
<style>
    .dashboard-header { margin-bottom: 2rem; }
    .dashboard-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; }
    .dashboard-header p { color: var(--gris); margin-top: 0.4rem; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
    .stat-card { background: white; border: 1px solid var(--gris-lgt); border-radius: 12px; padding: 1.25rem; }
    .stat-label { font-size: 0.82rem; color: var(--gris); margin-bottom: 0.5rem; }
    .stat-value { font-family: 'Playfair Display', serif; font-size: 1.8rem; }
    .stat-sub { font-size: 0.82rem; color: var(--gris); margin-top: 0.25rem; }
    .club-card { background: var(--noir); color: white; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
    .club-card h3 { font-family: 'Playfair Display', serif; color: var(--or); font-size: 1.3rem; }
    .club-card p { color: #aaa; font-size: 0.88rem; margin-top: 0.25rem; }
    .points-badge { background: var(--or); color: var(--noir); border-radius: 10px; padding: 0.75rem 1.25rem; text-align: center; }
    .points-badge strong { display: block; font-size: 1.5rem; font-family: 'Playfair Display', serif; }
    .points-badge span { font-size: 0.78rem; }
    .section-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; margin-bottom: 1rem; }
    .contrats-list { display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem; }
    .contrat-item { background: white; border: 1px solid var(--gris-lgt); border-radius: 10px; padding: 1.1rem 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
    .contrat-info strong { display: block; font-size: 0.95rem; }
    .contrat-info span { color: var(--gris); font-size: 0.85rem; }
    .empty { text-align: center; padding: 2.5rem; color: var(--gris); background: var(--creme); border-radius: 12px; }
</style>

<div class="dashboard-header">
    <h1>Bonjour, {{ auth()->user()->prenom }} 👋</h1>
    <p>Bienvenue dans votre espace client LocAutoPlus</p>
</div>

{{-- STATS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Contrats au total</div>
        <div class="stat-value">{{ auth()->user()->contrats->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Contrats en cours</div>
        <div class="stat-value">{{ $contratsEnCours->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Locations terminées</div>
        <div class="stat-value">{{ $contratsTermines->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Points Club</div>
        <div class="stat-value">{{ $user->clubMembre ? $user->clubMembre->points_total : 0 }}</div>
        <div class="stat-sub">{{ $user->clubMembre ? 'Niveau ' . $user->clubMembre->niveau->nom : 'Non membre' }}</div>
    </div>
</div>

{{-- CLUB --}}
@if($user->clubMembre)
<div class="club-card">
    <div>
        <h3>Club LocAutoPlus — {{ $user->clubMembre->niveau->nom }}</h3>
        <p>Réduction de {{ $user->clubMembre->niveau->reduction_pct }}% sur vos prochaines locations · Membre depuis le {{ $user->clubMembre->date_adhesion->format('d/m/Y') }}</p>
    </div>
    <div class="points-badge">
        <strong>{{ $user->clubMembre->points_total }}</strong>
        <span>points</span>
    </div>
</div>
@else
<div style="background:var(--creme);border-radius:12px;padding:1.25rem;margin-bottom:2rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">
    <div>
        <strong>Rejoignez le Club LocAutoPlus</strong>
        <p style="color:var(--gris);font-size:0.88rem;margin-top:0.25rem">L'adhésion est automatique après vos premières locations.</p>
    </div>
    <a href="{{ route('vehicules.index') }}" class="btn btn-gold">Réserver maintenant</a>
</div>
@endif

{{-- CONTRATS EN COURS --}}
<h2 class="section-title">Réservations en cours</h2>
@if($contratsEnCours->isEmpty())
    <div class="empty">Aucune réservation en cours. <a href="{{ route('vehicules.index') }}" style="color:var(--noir)">Réserver un véhicule</a></div>
@else
    <div class="contrats-list">
        @foreach($contratsEnCours as $contrat)
        <div class="contrat-item">
            <div class="contrat-info">
                <strong>{{ $contrat->vehicule->marque }} {{ $contrat->vehicule->modele }}</strong>
                <span>Du {{ $contrat->date_debut->format('d/m/Y') }} au {{ $contrat->date_fin_prevue->format('d/m/Y') }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:1rem">
                <span class="badge badge-{{ $contrat->statut }}">{{ ucfirst(str_replace('_', ' ', $contrat->statut)) }}</span>
                <strong>{{ number_format($contrat->montant_total, 2, ',', ' ') }} €</strong>
                <a href="{{ route('contrats.show', $contrat->id) }}" class="btn btn-outline" style="padding:0.4rem 0.9rem;font-size:0.85rem">Détail</a>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- HISTORIQUE --}}
<h2 class="section-title" style="margin-top:2rem">Historique des locations</h2>
@if($contratsTermines->isEmpty())
    <div class="empty">Aucune location terminée pour l'instant.</div>
@else
    <div class="contrats-list">
        @foreach($contratsTermines as $contrat)
        <div class="contrat-item">
            <div class="contrat-info">
                <strong>{{ $contrat->vehicule->marque }} {{ $contrat->vehicule->modele }}</strong>
                <span>Du {{ $contrat->date_debut->format('d/m/Y') }} au {{ $contrat->date_fin_reelle->format('d/m/Y') }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:1rem">
                <span class="badge badge-terminee">Terminée</span>
                <strong>{{ number_format($contrat->montant_total, 2, ',', ' ') }} €</strong>
                <a href="{{ route('contrats.show', $contrat->id) }}" class="btn btn-outline" style="padding:0.4rem 0.9rem;font-size:0.85rem">Détail</a>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
