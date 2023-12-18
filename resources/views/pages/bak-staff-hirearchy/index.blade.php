<x-app-layout>
    <button class="btn" onclick="my_modal_3.showModal()">Tambah Unit</button>
    <button class="btn" onclick="my_modal_3.showModal()">Tambah Bahagian</button>

    @foreach ($staffSections as $staffSection)
        Nama: {{ $staffSection->name }} <br>
        Jumlah Unit: {{ $staffSection->staffUnitCount }} <br>
        Jumlah logkerja: {{ $staffSection->workLogCount }} <br>
        Jumlah staff: {{ $staffSection->staffCount }} <br>
        <a href="/staff-sections/{{ $staffSection->id }}">Buka</a> <br>
    @endforeach

    <!-- You can open the modal using ID.showModal() method -->
    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Tambah disini</h3>
            <p class="py-4">Press ESC key or click on ✕ button to close</p>
        </div>
    </dialog>
</x-app-layout>
