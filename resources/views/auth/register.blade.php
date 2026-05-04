@extends('layouts.app')
@section('title', 'Créer un compte')

@section('content')
<style>
    .auth-wrap { max-width: 560px; margin: 2rem auto; }
    .auth-header { text-align: center; margin-bottom: 2rem; }
    .auth-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; }
    .auth-header p { color: var(--gris); margin-top: 0.5rem; }
    .auth-card { background: white; border: 1px solid var(--gris-lgt); border-radius: 16px; padding: 2rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .auth-footer { text-align: center; margin-top: 1.25rem; font-size: 0.9rem; color: var(--gris); }
    .auth-footer a { color: var(--noir); font-weight: 500; }
</style>

<div class="auth-wrap">
    <div class="auth-header">
        <h1>Créer un compte</h1>
        <p>Rejoignez LocAutoPlus et profitez du Club fidélité</p>
    </div>

    <div class="auth-card">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Dupont" required>
                    @error('nom') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Jean" required>
                    @error('prenom') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Adresse e-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.fr" required>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="Min. 8 caractères" required>
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>
            </div>
            <div class="form-group">
                <label>Téléphone <span style="color:var(--gris);font-weight:300">(optionnel)</span></label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="06 12 34 56 78">
            </div>
            <div class="form-group">
                <label>Adresse <span style="color:var(--gris);font-weight:300">(optionnel)</span></label>
                <input type="text" name="adresse" value="{{ old('adresse') }}" placeholder="12 rue des Lilas, 30000 Nîmes">
            </div>
            <div class="form-group">
                <label>Date de naissance <span style="color:var(--gris);font-weight:300">(optionnel)</span></label>
                <input type="date" name="date_naissance" value="{{ old('date_naissance') }}">
            </div>
            <button type="submit" class="btn btn-gold" style="width:100%;padding:0.8rem">Créer mon compte</button>
        </form>
    </div>

    <div class="auth-footer">
        Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>
@endsection
