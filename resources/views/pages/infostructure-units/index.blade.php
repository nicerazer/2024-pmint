<x-app-layout>
    @foreach ($staffUnits as $staffUnit)
        Nama: {{ $staffUnit->name }}
        Jumlah logkerja: {{ $staffUnit->workLogCount }}
        Jumlah staff: {{ $staffUnit->staffCount }}
        <a href="/staff-units/{{ $staffUnit->id }}">Buka</a>
    @endforeach
</x-app-layout>
