<x-app-layout>
    <x-slot:header></x-slot:header>

    <input type="text" placeholder="Isi Carian">
    <a href="/bahagian/create">Tambah Bahagian</a>
    @foreach (App\Models\StaffSection::all() as $staffSection)
        Staff Section
        <a href="/staff-sections/{{ $staffSection->id }}">Buka</a>
    @endforeach
</x-app-layout>
