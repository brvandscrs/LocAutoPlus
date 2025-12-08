@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Contrats</h1>

    <a href="{{ route('contrat.create') }}" class="btn btn-primary mb-3">
        Nouveau Contrat
    </a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Montant</th>
                <th>État</th>
                <th width="280px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contrats as $contrat)
            <tr>
                <td>{{ $contrat->id }}</td>
                <td>{{ $contrat->date_debut }}</td>
                <td>{{ $contrat->date_fin }}</td>
                <td>{{ number_format($contrat->montant, 2, ',', ' ') }} €</td>
                <td>{{ $contrat->etat_contrat }}</td>
                <td>
                    <form action="{{ route('contrat.destroy', $contrat->id) }}" method="POST">

                        <a class="btn btn-info btn-sm" href="{{ route('contrat.edit', $contrat->id) }}">
                            Modifier
                        </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
