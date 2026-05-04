@extends('layouts.app')
@section('title', 'Contrat #' . $contrat->id)

@section('content')
<style>
    .back-link { color: var(--gris); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.4rem; margin-bottom: 1.5rem; }
    .contrat-layout { display: grid; grid-template-columns: 1fr 320px; gap: 2rem; align-items: start; }
    @media(max-width: 768px) { .contrat-layout { grid-template-columns: 1fr; } }
    .contrat-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 0.5rem; }
    .section { background: white; border: 1px solid var(--gris-lgt); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.25rem; }
    .section h3 { font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gris); margin-bottom: 1rem; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .info-item label { font-size: 0.78rem; color: var(--gris); display: block; margin-bottom: 0.2rem; }
    .info-item span { font-weight: 500; }
    .montant-recap { display: flex; flex-direction: column; gap: 0.6rem; }
    .montant-ligne { display: flex; justify-content: space-between; font-size: 0.9rem; color: var(--gris); }
    .montant-total { display: flex; justify-content: space-between; font-weight: 600; font-size: 1.1rem; padding-top: 0.75rem; border-top: 1.5px solid var(--gris-lgt); margin-top: 0.25rem; }
</style>

<a href="{{ route('contrats.index') }}" class="back-link">← Mes contrats</a>

<div class="contrat-layout">
    <div>
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
            <h1 class="contrat-title">Contrat #{{ $contrat->id }}</h1>
            <span class="badge badge-{{ $contrat->statut }}" style="font-size:0.85rem;padding:0.4rem 1rem">{{ ucfirst(str_replace('_', ' ', $contrat->statut)) }}</span>
        </div>

        <div class="section">
            <h3>Véhicule</h3>
            <div class="info-grid">
                <div class="info-item"><label>Marque / Modèle</label><span>{{ $contrat->vehicule->marque }} {{ $contrat->vehicule->modele }}</span></div>
                <div class="info-item"><label>Catégorie</label><span>{{ $contrat->vehicule->categorie->nom }}</span></div>
                <div class="info-item"><label>Immatriculation</label><span>{{ $contrat->vehicule->immatriculation }}</span></div>
                <div class="info-item"><label>Année</label><span>{{ $contrat->vehicule->annee }}</span></div>
            </div>
        </div>

        <div class="section">
            <h3>Dates de location</h3>
            <div class="info-grid">
                <div class="info-item"><label>Date de réservation</label><span>{{ $contrat->date_reservation->format('d/m/Y à H:i') }}</span></div>
                <div class="info-item"><label>Date de début</label><span>{{ $contrat->date_debut->format('d/m/Y') }}</span></div>
                <div class="info-item"><label>Date de fin prévue</label><span>{{ $contrat->date_fin_prevue->format('d/m/Y') }}</span></div>
                <div class="info-item">
                    <label>Date de retour réelle</label>
                    <span>{{ $contrat->date_fin_reelle ? $contrat->date_fin_reelle->format('d/m/Y') : '—' }}</span>
                </div>
                @if($contrat->km_depart)
                <div class="info-item"><label>Km départ</label><span>{{ number_format($contrat->km_depart) }} km</span></div>
                @endif
                @if($contrat->km_retour)
                <div class="info-item"><label>Km retour</label><span>{{ number_format($contrat->km_retour) }} km</span></div>
                @endif
            </div>
        </div>

        @if($contrat->employe)
        <div class="section">
            <h3>Employé référent</h3>
            <span>{{ $contrat->employe->prenom }} {{ $contrat->employe->nom }}</span>
        </div>
        @endif

        @if($contrat->notes)
        <div class="section">
            <h3>Notes</h3>
            <p style="color:var(--gris);line-height:1.7">{{ $contrat->notes }}</p>
        </div>
        @endif
    </div>

    <div class="section" style="position:sticky;top:80px">
        <h3>Récapitulatif financier</h3>
        <div class="montant-recap">
            <div class="montant-ligne">
                <span>Montant de base</span>
                <span>{{ number_format($contrat->montant_base, 2, ',', ' ') }} €</span>
            </div>
            @if($contrat->reduction_appliquee > 0)
            <div class="montant-ligne" style="color:var(--vert)">
                <span>Réduction Club ({{ $contrat->reduction_appliquee }}%)</span>
                <span>- {{ number_format($contrat->montant_base * $contrat->reduction_appliquee / 100, 2, ',', ' ') }} €</span>
            </div>
            @endif
            <div class="montant-total">
                <span>Total</span>
                <span>{{ number_format($contrat->montant_total, 2, ',', ' ') }} €</span>
            </div>
        </div>
    </div>
</div>
@endsection
