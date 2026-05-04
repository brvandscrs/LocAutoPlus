@extends('layouts.app')
@section('title', 'Accueil')

@section('content')
<style>
    .hero {
        background: var(--noir);
        color: white;
        padding: 4rem 3rem;
        border-radius: 16px;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 300px; height: 300px;
        background: var(--or);
        border-radius: 50%;
        opacity: 0.08;
    }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; margin-bottom: 1rem; line-height: 1.2; }
    .hero h1 span { color: var(--or); }
    .hero p { color: #aaa; font-size: 1.05rem; max-width: 500px; margin-bottom: 2rem; line-height: 1.7; }
    .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
    .section-subtitle { color: var(--gris); margin-bottom: 2rem; font-size: 0.95rem; }

    .vehicules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .vehicule-card {
        background: white;
        border: 1px solid var(--gris-lgt);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .vehicule-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); }

    .vehicule-img {
        height: 160px;
        background: var(--creme);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
    }

    .vehicule-body { padding: 1.25rem; }
    .vehicule-title { font-weight: 500; font-size: 1.05rem; margin-bottom: 0.25rem; }
    .vehicule-cat { color: var(--gris); font-size: 0.85rem; margin-bottom: 0.75rem; }
    .vehicule-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; }
    .vehicule-prix { font-family: 'Playfair Display', serif; font-size: 1.3rem; }
    .vehicule-prix small { font-family: 'DM Sans', sans-serif; font-size: 0.75rem; color: var(--gris); }

    .avantages {
        background: var(--creme);
        border-radius: 16px;
        padding: 3rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    .avantage-item { text-align: center; }
    .avantage-icon { font-size: 2rem; margin-bottom: 0.75rem; }
    .avantage-titre { font-weight: 500; margin-bottom: 0.4rem; }
    .avantage-desc { font-size: 0.85rem; color: var(--gris); line-height: 1.6; }

    .club-banner {
        background: linear-gradient(135deg, var(--noir) 0%, #2c2416 100%);
        color: white;
        border-radius: 16px;
        padding: 2.5rem 3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .club-banner h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; }
    .club-banner h2 span { color: var(--or); }
    .club-banner p { color: #aaa; margin-top: 0.5rem; max-width: 500px; line-height: 1.6; }
</style>

{{-- HERO --}}
<div class="hero">
    <h1>Louez le véhicule<br>de vos <span>envies</span></h1>
    <p>Une agence unique, un service VIP. Réservez en quelques clics et profitez des avantages exclusifs du Club LocAutoPlus.</p>
    <div class="hero-btns">
        <a href="{{ route('vehicules.index') }}" class="btn btn-gold">Voir nos véhicules</a>
        @guest
            <a href="{{ route('register') }}" class="btn btn-outline" style="border-color:#555;color:#ccc;">Créer un compte</a>
        @endguest
    </div>
</div>

{{-- VÉHICULES EN VEDETTE --}}
<h2 class="section-title">Véhicules disponibles</h2>
<p class="section-subtitle">Sélection de nos véhicules prêts à partir dès aujourd'hui</p>

<div class="vehicules-grid">
    @foreach($vehiculesDisponibles as $vehicule)
    <div class="vehicule-card">
        <div class="vehicule-img">🚗</div>
        <div class="vehicule-body">
            <div class="vehicule-title">{{ $vehicule->marque }} {{ $vehicule->modele }}</div>
            <div class="vehicule-cat">{{ $vehicule->categorie->nom }} · {{ $vehicule->annee }}</div>
            <span class="badge badge-dispo">Disponible</span>
            <div class="vehicule-footer">
                <div class="vehicule-prix">
                    {{ number_format($vehicule->categorie->tarif_base_jour, 2, ',', ' ') }} €
                    <small>/ jour</small>
                </div>
                <a href="{{ route('vehicules.show', $vehicule->id) }}" class="btn btn-primary">Voir</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- AVANTAGES --}}
<div class="avantages">
    <div class="avantage-item">
        <div class="avantage-icon">🚘</div>
        <div class="avantage-titre">Flotte variée</div>
        <div class="avantage-desc">Citadines, berlines, SUV, utilitaires et véhicules de luxe.</div>
    </div>
    <div class="avantage-item">
        <div class="avantage-icon">⚡</div>
        <div class="avantage-titre">Réservation rapide</div>
        <div class="avantage-desc">En ligne, 24h/24, en moins de 2 minutes.</div>
    </div>
    <div class="avantage-item">
        <div class="avantage-icon">🛡️</div>
        <div class="avantage-titre">Assurance incluse</div>
        <div class="avantage-desc">Tous nos véhicules sont couverts lors de la location.</div>
    </div>
    <div class="avantage-item">
        <div class="avantage-icon">⭐</div>
        <div class="avantage-titre">Service VIP</div>
        <div class="avantage-desc">Adhésion automatique au Club LocAutoPlus pour les clients fidèles.</div>
    </div>
</div>

{{-- BANNIÈRE CLUB --}}
<div class="club-banner">
    <div>
        <h2>Le Club <span>LocAutoPlus</span></h2>
        <p>Chaque location vous rapporte des points. Atteignez les paliers Bronze, Silver ou Gold et profitez de réductions exclusives sur vos prochaines locations.</p>
    </div>
    @guest
        <a href="{{ route('register') }}" class="btn btn-gold">Rejoindre le club</a>
    @else
        <a href="{{ route('dashboard') }}" class="btn btn-gold">Mon espace</a>
    @endguest
</div>
@endsection
