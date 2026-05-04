<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocAutoPlus – @yield('title', 'Location de véhicules')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --noir:     #0f0f0f;
            --blanc:    #fafaf8;
            --creme:    #f4f0e8;
            --or:       #c9a84c;
            --or-clair: #e8d5a3;
            --gris:     #6b6b6b;
            --gris-lgt: #e8e8e4;
            --rouge:    #c0392b;
            --vert:     #27ae60;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--blanc);
            color: var(--noir);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        nav {
            background: var(--noir);
            padding: 0 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            color: var(--or);
            font-size: 1.4rem;
            text-decoration: none;
            letter-spacing: 0.02em;
        }

        .nav-links { display: flex; align-items: center; gap: 0.25rem; }

        .nav-links a {
            color: #ccc;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 400;
            transition: color 0.2s, background 0.2s;
        }

        .nav-links a:hover { color: var(--blanc); background: rgba(255,255,255,0.08); }

        .nav-links a.btn-gold {
            background: var(--or);
            color: var(--noir);
            font-weight: 500;
            margin-left: 0.5rem;
        }

        .nav-links a.btn-gold:hover { background: var(--or-clair); }

        .nav-links form button {
            background: none;
            border: 1px solid #555;
            color: #ccc;
            padding: 0.45rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .nav-links form button:hover { border-color: var(--or); color: var(--or); }

        /* ── CONTENU ── */
        main { flex: 1; padding: 2.5rem; max-width: 1200px; margin: 0 auto; width: 100%; }

        /* ── ALERTES ── */
        .alert {
            padding: 0.9rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid var(--vert); }
        .alert-error   { background: #f8d7da; color: #721c24; border-left: 4px solid var(--rouge); }

        /* ── CARDS ── */
        .card {
            background: white;
            border: 1px solid var(--gris-lgt);
            border-radius: 12px;
            padding: 1.5rem;
            transition: box-shadow 0.2s;
        }
        .card:hover { box-shadow: 0 4px 24px rgba(0,0,0,0.08); }

        /* ── BOUTONS ── */
        .btn {
            display: inline-block;
            padding: 0.65rem 1.5rem;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }
        .btn-primary  { background: var(--noir); color: white; }
        .btn-primary:hover  { background: #2c2c2c; }
        .btn-gold     { background: var(--or); color: var(--noir); }
        .btn-gold:hover     { background: var(--or-clair); }
        .btn-outline  { background: transparent; border: 1.5px solid var(--noir); color: var(--noir); }
        .btn-outline:hover  { background: var(--noir); color: white; }

        /* ── FORMULAIRES ── */
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.4rem; color: var(--gris); }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--gris-lgt);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            transition: border-color 0.2s;
            background: white;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--or);
        }
        .form-error { color: var(--rouge); font-size: 0.8rem; margin-top: 0.3rem; }

        /* ── BADGES STATUT ── */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 500;
        }
        .badge-attente   { background: #fff3cd; color: #856404; }
        .badge-confirmee { background: #cce5ff; color: #004085; }
        .badge-en_cours  { background: #d4edda; color: #155724; }
        .badge-terminee  { background: #e2e3e5; color: #383d41; }
        .badge-annulee   { background: #f8d7da; color: #721c24; }
        .badge-dispo     { background: #d4edda; color: #155724; }
        .badge-loue      { background: #f8d7da; color: #721c24; }

        /* ── FOOTER ── */
        footer {
            background: var(--noir);
            color: #888;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.82rem;
        }
        footer span { color: var(--or); }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">LocAuto<span style="color:white">Plus</span></a>
    <div class="nav-links">
        <a href="{{ route('vehicules.index') }}">Nos véhicules</a>
        @auth
            <a href="{{ route('dashboard') }}">Mon espace</a>
            <a href="{{ route('contrats.index') }}">Mes contrats</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}">Connexion</a>
            <a href="{{ route('register') }}" class="btn-gold">Créer un compte</a>
        @endauth
    </div>
</nav>

<main>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<footer>
    &copy; {{ date('Y') }} <span>LocAutoPlus</span> — Tous droits réservés
</footer>

</body>
</html>
