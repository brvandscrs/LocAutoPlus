@extends('layouts.app')
@section('title', 'Nos véhicules')

@section('content')
<style>
    .page-header { margin-bottom: 2rem; }
    .page-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; }
    .page-header p { color: var(--gris); margin-top: 0.4rem; }
    .filtres {
        background: var(--creme);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
        margin-bottom: 2rem;
    }
    .filtres .form-group { margin: 0; flex: 1; min-width: 180px; }
    .vehicules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .vehicule-card { background: white; border: 1px solid var(--gris-lgt); border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
    .vehicule-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
    .vehicule-img { height: 160px; background: var(--creme); display: flex; align-items: center; justify-content: center; font-size: 3.5rem; }
    .vehicule-body { padding: 1.25rem; }
    .vehicule-title { font-weight: 500; font-size: 1.05rem; margin-bottom: 0.25rem; }
    .vehicule-cat { color: var(--gris); font-size: 0.85rem; margin-bottom: 0.75rem; }
    .vehicule-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; }
    .vehicule-prix { font-family: 'Playfair Display', serif; font-size: 1.3rem; }
    .vehicule-prix small { font-family: 'DM Sans', sans-serif; font-size: 0.75rem; color: var(--gris); }
    .empty { text-align: center; padding: 4rem; color: var(--gris); }
    .empty-icon { font-size: 3rem; margin-bottom: 1rem; }
</style>

<div class="page-header">
    <h1>Nos véhicules</h1>
    <p>{{ $vehicules->count() }} véhicule(s) disponible(s)</p>
</div>

<form method="GET" action="{{ route('vehicules.index') }}" class="filtres">
    <div class="form-group">
        <label>Catégorie</label>
        <select name="categorie">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nom }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Marque</label>
        <input type="text" name="marque" value="{{ request('marque') }}" placeholder="Ex: Renault">
    </div>
    <button type="submit" class="btn btn-primary">Filtrer</button>
    <a href="{{ route('vehicules.index') }}" class="btn btn-outline">Réinitialiser</a>
</form>

@if($vehicules->isEmpty())
    <div class="empty">
        <div class="empty-icon">🔍</div>
        <p>Aucun véhicule ne correspond à votre recherche.</p>
    </div>
@else
    <div class="vehicules-grid">
        @foreach($vehicules as $vehicule)
        <div class="vehicule-card">
            <div class="vehicule-img">🚗</div>
            <div class="vehicule-body">
                <div class="vehicule-title">{{ $vehicule->marque }} {{ $vehicule->modele }}</div>
                <div class="vehicule-cat">{{ $vehicule->categorie->nom }} · {{ $vehicule->annee }} · {{ number_format($vehicule->km_actuel) }} km</div>
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
@endif
@endsection
