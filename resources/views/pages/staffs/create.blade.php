<x-app-layout>
    <form action="/staff-units" method="POST">
        @csrf
        <input type="text" placeholder="Nama unit staff" name="name">
        <button>Submit</button>
    </form>
</x-app-layout>
