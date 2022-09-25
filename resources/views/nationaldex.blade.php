<x-app-layout>
    <x-navigation></x-navigation>
    <div class="text-center mb-3 mt-3">
        <h1 class="text-3xl">National Dex</h1>
        <p>Every Pokemon Ever.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-w-screen-xl mx-auto">
        @foreach($results as $species)
            <x-national-dex-card :name="$species['name']" :ndex="sprintf('%03d', random_int(1,999))"/>
        @endforeach
    </div>
</x-app-layout>
