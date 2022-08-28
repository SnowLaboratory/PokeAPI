<x-app-layout>
    <x-navigation></x-navigation>
    <div class="text-center mb-3 mt-3">
        <h1 class="text-3xl">Region I</h1>
        <p>Kanto</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-w-screen-xl mx-auto">
        @foreach($results['pokemon_species'] as $result)
            <x-pokedex-card :name="$result['name']" />
        @endforeach
    </div>
</x-app-layout>
