<x-app-layout>
    <form action="/staff-sections" method="POST">
        @csrf
        <input type="text" placeholder="Nama bahagian staff" name="name">
        <button>Submit</button>
    </form>
</x-app-layout>
