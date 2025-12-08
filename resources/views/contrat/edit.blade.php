@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier un Contrat</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contrats.update', ['contrat' => $contrat->id]) }}" method="POST">
        @csrf
        @method("PUT")

        <div class="form-group">
            <label for="date_debut">Date de Début :</label>
            <input type="date" name="date_debut" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="date_fin">Date de Fin :</label>
            <input type="date" name="date_fin" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="montant">Montant :</label>
            <input type="number" step="0.01" name="montant" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="etat_contrat">État du Contrat :</label>
            <input type="text" name="etat_contrat" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Modifier</button>
        <a href="{{ route('contrats.index') }}" class="btn btn-secondary mt-3">Annuler</a>
    </form>
</div>
@endsection