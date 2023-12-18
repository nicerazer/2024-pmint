<x-app-layout>
    <x-slot:header>

    </x-slot:header>

    <div class="flex flex-col items-start w-5/6 gap-4 mx-auto">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="/">Bahagian</a></li>
                <li>{{ $staffSection->name }}</li>
            </ul>
        </div>

        @if (session('status'))
            <div role="alert" class="text-white alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <h1 class="text-xl">Senarai Unit</h1>

        <div class="flex items-center justify-between w-full">
            <div class="flex items-center flex-1 max-w-lg gap-4">
                <input type="text" placeholder="Isi carian" class="w-full input input-md input-bordered" />
                <button class="label-text-alt link link-neutral">Clear</span>
            </div>
            <label for="modal_add_unit" class="btn btn-primary">
                Cipta Unit
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path
                        d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                    <path
                        d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                </svg>
            </label>
            {{-- <a href="/bahagian/{{ $staffSection->id }}/unit/cipta" class="btn btn-primary">Cipta Unit</a> --}}
        </div>

        <div class="w-full overflow-x-auto bg-white shadow card">
            <table class="table tabs-sm">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Jumlah Staff</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($staffSection->staffUnits as $staffUnit)
                        <tr class="hover">
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ ucfirst($staffUnit->name) }}</td>
                            <td>{{ $staffUnit->staffCount() }}</td>
                            <td>
                                <a class="btn-primary btn btn-ghost"
                                    href="/bahagian/{{ $staffSection->id }}/unit/{{ $staffUnit->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <!-- Add staff unit  -->
    <input type="checkbox" id="modal_add_unit" class="modal-toggle" />
    <div class="modal" role="dialog">
        <form class="modal-box" method="POST" action="/bahagian/{{ $staffUnit->staffSection->id }}/unit">
            @method('POST')
            @csrf
            <h3 class="text-lg font-bold">Tambah unit</h3>
            <input type="text" class="w-full mt-4 input-bordered input" placeholder="Isi nama unit" name="name">
            <div class="modal-action">
                <label for="modal_add_unit" class="btn">Batal</label>
                <button class="btn btn-primary">Hantar</button>
            </div>
        </form>
    </div>
</x-app-layout>
