<x-guest-layout>
    <form action="/reservation" method="POST">
        @csrf
            <h2>Réservation</h2>
        <div style="border: 1px solid black; padding: 20px; display: flex; flex-direction: row; gap: 10px;">

            <div>
                Départ :
                <input type="date" name="datedebut" id="datedebut" value="{{ isset($datedebut) ? $datedebut : '' }}">
                <input type="time" name="heuredebut" id="heuredebut" value="{{ isset($heuredebut) ? $heuredebut : '' }}">
            </div>
            <div>
                Retour :
                <input type="date" name="datefin" id="datefin" value="{{ isset($datefin) ? $datefin : '' }}">
                <input type="time" name="heurefin" id="heurefin" value="{{ isset($heurefin) ? $heurefin : '' }}">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="vehicules">
            @foreach ($vehicules as $vehicule)
                <div style="border: 1px solid black; padding: 10px; margin-top: 10px;">
                    <h3>{{ $vehicule->marque }} {{ $vehicule->modele }}</h3>
                    <p>Motorisation : {{ $vehicule->motorisation }}</p>
                    <p>Nombre de portes : {{ $vehicule->nb_portes }}</p>
                    <p>Nombre de places : {{ $vehicule->nb_places }}</p>
                    <p>Type de boîte de vitesse : {{ $vehicule->type_boite_vitesse }}</p>
                    <p>Âge minimum requis : {{ $vehicule->age_minimum }} ans</p>
                    <p>Prix journalier : {{ $vehicule->prix_journalier }}€</p>
                </div>
                test
            @endforeach
        </div>
    </form>
</x-guest-layout>