@extends('layouts.app')
@section('title', 'Mes contrats')

@section('content')
<style>
    .page-header { margin-bottom: 2rem; }
    .page-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; }
    .contrats-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid var(--gris-lgt); }
    .contrats-table th { background: var(--creme); padding: 0.9rem 1.1rem; text-align: left; font-size: 0.82rem; color: var(--gris); font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; }
    .contrats-table td { padding: 1rem 1.1rem; border-top: 1px solid var(--gris-lgt); font-size: 0.92rem; }
    .contrats-table tr:hover td { background: #fafaf8; }
    .empty { text-align: center; padding: 4rem; color: var(--gris); }
</style>

<div class="page-header">
    <h1>Mes contrats</h1>
</div>

@if($contrats->isEmpty())
    <div class="empty">
        <div style="font-size:3rem;margin-bottom:1rem">📋</div>
        <p>Vous n'avez pas encore de contrat.</p>
        <a href="{{ route('vehicules.index') }}" class="btn btn-gold" style="margin-top:1rem">Réserver un véhicule</a>
    </div>
@else
    <table class="contrats-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Véhicule</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Montant</th>
                <th>Statut</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($contrats as $contrat)
            <tr>
                <td style="color:var(--gris)">{{ $contrat->id }}</td>
                <td><strong>{{ $contrat->vehicule->marque }} {{ $contrat->vehicule->modele }}</strong><br><small style="color:var(--gris)">{{ $contrat->vehicule->categorie->nom }}</small></td>
                <td>{{ $contrat->date_debut->format('d/m/Y') }}</td>
                <td>{{ $contrat->date_fin_prevue->format('d/m/Y') }}</td>
                <td><strong>{{ number_format($contrat->montant_total, 2, ',', ' ') }} €</strong></td>
                <td><span class="badge badge-{{ $contrat->statut }}">{{ ucfirst(str_replace('_', ' ', $contrat->statut)) }}</span></td>
                <td><a href="{{ route('contrats.show', $contrat->id) }}" class="btn btn-outline" style="padding:0.35rem 0.8rem;font-size:0.82rem">Voir</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
