<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Liste des véhicules</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($vehicules as $vehicule)
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                <div class="bg-indigo-600 p-4">
                    <p class="text-white font-bold tracking-widest text-sm uppercase">
                        VÉHICULE #{{ $vehicule->id }}
                    </p>
                </div>
                
                <div class="p-5 space-y-2">
                    <h2 class="text-xl font-bold text-gray-900 border-b pb-2 uppercase">
                        {{ $vehicule->marque }} {{ $vehicule->modele }}
                    </h2>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 pt-2">
                        <p><span class="font-semibold">Moteur :</span> {{ $vehicule->motorisation }}</p>
                        <p><span class="font-semibold">Portes :</span> {{ $vehicule->nb_portes }}</p>
                        <p><span class="font-semibold">Places :</span> {{ $vehicule->nb_places }}</p>
                        <p><span class="font-semibold">Boîte :</span> {{ $vehicule->type_boite_vitesse }}</p>
                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Âge requis</p>
                            <p class="font-bold">{{ $vehicule->age_minimum }} ans</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase">Tarif</p>
                            <p class="text-2xl font-black text-indigo-600">{{ $vehicule->prix_journalier }}€<span class="text-sm font-normal">/jour</span></p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 border-t">
                    <button class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Réserver ce véhicule
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>