@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<style>
    .auth-wrap { max-width: 440px; margin: 2rem auto; }
    .auth-header { text-align: center; margin-bottom: 2rem; }
    .auth-header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; }
    .auth-header p { color: var(--gris); margin-top: 0.5rem; }
    .auth-card { background: white; border: 1px solid var(--gris-lgt); border-radius: 16px; padding: 2rem; }
    .auth-footer { text-align: center; margin-top: 1.25rem; font-size: 0.9rem; color: var(--gris); }
    .auth-footer a { color: var(--noir); font-weight: 500; }
    .divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; color: var(--gris); font-size: 0.85rem; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--gris-lgt); }
</style>

<div class="auth-wrap">
    <div class="auth-header">
        <h1>Bon retour 👋</h1>
        <p>Connectez-vous à votre espace client</p>
    </div>

    <div class="auth-card">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.fr" required>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="form-group" style="display:flex;align-items:center;gap:0.5rem">
                <input type="checkbox" id="remember" name="remember" style="width:auto">
                <label for="remember" style="margin:0;font-size:0.9rem;color:var(--gris)">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;padding:0.8rem">Se connecter</button>
        </form>
    </div>

    <div class="auth-footer">
        Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a>
    </div>
</div>
@endsection
