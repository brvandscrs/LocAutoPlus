@extends('layouts.app')
@section('title', 'Réserver')

@section('content')
<style>
    .resa-wrap { max-width: 700px; margin: 0 auto; }
    .resa-header { margin-bottom: 2rem; }
    .resa-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; }
    .resa-header p { color: var(--gris); margin-top: 0.4rem; }
    .resa-vehicule { background: var(--creme); border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1.25rem; margin-bottom: 2rem; }
    .resa-vehicule-icon { font-size: 2.5rem; }
    .resa-vehicule-info strong { display: block; font-size: 1.05rem; }
    .resa-vehicule-info span { color: var(--gris); font-size: 0.9rem; }
    .resa-card { background: white; border: 1px solid var(--gris-lgt); border-radius: 16px; padding: 2rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .recap { background: var(--creme); border-radius: 10px; padding: 1.25rem; margin-top: 1.5rem; }
    .recap-title { font-weight: 500; margin-bottom: 0.75rem; }
    .recap-ligne { display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.4rem; color: var(--gris); }
    .recap-total { display: flex; justify-content: space-between; font-weight: 600; font-size: 1.05rem; padding-top: 0.75rem; border-top: 1px solid var(--gris-lgt); margin-top: 0.5rem; }
</style>

<div class="resa-wrap">
    <div class="resa-header">
        <a href="{{ route('vehicules.show', $vehicule->id) }}" style="color:var(--gris);text-decoration:none;font-size:0.9rem">← Retour</a>
        <h1 style="margin-top:0.75rem">Réserver un véhicule</h1>
        <p>Choisissez vos dates de location</p>
    </div>

    <div class="resa-vehicule">
        <div class="resa-vehicule-icon">🚗</div>
        <div class="resa-vehicule-info">
            <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong>
            <span>{{ $vehicule->categorie->nom }} · {{ number_format($vehicule->categorie->tarif_base_jour, 2, ',', ' ') }} € / jour</span>
        </div>
    </div>

    <div class="resa-card">
        <form action="{{ route('reservation.store', $vehicule->id) }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Date de début</label>
                    <input type="date" name="date_debut" value="{{ old('date_debut') }}" min="{{ date('Y-m-d') }}" required>
                    @error('date_debut') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Date de fin prévue</label>
                    <input type="date" name="date_fin_prevue" value="{{ old('date_fin_prevue') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    @error('date_fin_prevue') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="recap">
                <div class="recap-title">Récapitulatif estimé</div>
                <div class="recap-ligne">
                    <span>Tarif journalier</span>
                    <span>{{ number_format($vehicule->categorie->tarif_base_jour, 2, ',', ' ') }} €</span>
                </div>
                @if(auth()->user()->clubMembre)
                <div class="recap-ligne" style="color:var(--vert)">
                    <span>⭐ Réduction Club ({{ auth()->user()->clubMembre->niveau->reduction_pct }}%)</span>
                    <span>- {{ auth()->user()->clubMembre->niveau->reduction_pct }}%</span>
                </div>
                @endif
                <div class="recap-total">
                    <span>Total calculé à la validation</span>
                </div>
            </div>

            <button type="submit" class="btn btn-gold" style="width:100%;padding:0.9rem;margin-top:1.5rem;font-size:1rem">
                Confirmer la réservation
            </button>
        </form>
    </div>
</div>
@endsection
