<x-app-layout>
    {{ $staffSection->name }}
    Kemaskini unit dan bahagian yang berkaitan
    <form action="/staff-sections/{{ $staffSection->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" placeholder="Isi nama bahagian" value="{{ $staffSection->name }}">
        <button>Submit</button>
    </form>
    @foreach ($staffSection->staffUnits as $staffUnit)
        Edit Staff Unit
        <form action="/staff-units/{{ $staffUnit->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="name" placeholder="Isi nama unit" value="{{ $staffUnit->name }}">
            <button>Submit</button>
        </form>
        @foreach ($staffUnit->workScopes as $workScope)
            $workScope->title
        @endforeach

        @foreach ($staffUnit->staffs as $staff)
            {{ $staff->name }}
            Remove staff from unit / reassign
        @endforeach
    @endforeach

    Add members unassigned members into section?
</x-app-layout>
