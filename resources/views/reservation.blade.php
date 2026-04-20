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
        <div id="vehicules" class="vehicules">
            @foreach($vehicules as $vehicule)
                <div class="vehicule">
                    <h3>{{ $vehicule->marque }} {{ $vehicule->modele }}</h3>
                    <p>Type : {{ $vehicule->type }}</p>
                    <p>Prix : {{ $vehicule->prix }} €</p>
                    <button type="submit" name="vehicule_id" value="{{ $vehicule->id }}">Réserver</button>
                </div>
            @endforeach
        </div>
    </form>
</x-guest-layout>