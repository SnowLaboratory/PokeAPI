<x-app-layout>
    <h1 class="text-3xl uppercase font-bold">{{ $name }}</h1>
    <ul>
        @foreach($species as $specimen)
            <li><a href="/pokemon/{{ $speciman->name }}">{{ $speciman->name }}</a></li>
        @endforeach
    </ul>
</x-app-layout>
