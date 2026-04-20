<x-guest-layout>
    <form action="/reservation" method="POST">
        @csrf
            <h2>Réservation</h2>
        <div style="border: 1px solid black; padding: 20px; display: flex; flex-direction: row; gap: 10px;">

            <div>
                Départ :
                <input type="date" name="datedebut" id="datedebut">
                <input type="time" name="heuredebut" id="heuredebut">
            </div>
            <div>
                Retour :
                <input type="date" name="datefin" id="datefin">
                <input type="time" name="heurefin" id="heurefin">
            </div>
        </div>
        <div id="vehicules">
            Liste des véhicules disponibles sera affichée ici
        </div>
    </form>
</x-guest-layout>