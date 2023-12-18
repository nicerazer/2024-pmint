<x-app-layout>
    <x-slot:header>

    </x-slot:header>

    <div class="flex flex-col items-start w-5/6 gap-4 mx-auto" x-data="{ tabSelectIsStaff: false }">
        <div class="flex justify-between w-full">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="/">Bahagian</a></li>
                    <li>{{ $staffSection->name }}</li>
                    <li><a href="/bahagian/{{ $staffSection->id }}">Unit</a></li>
                    <li class="font-bold">{{ $staffUnit->name }}</li>
                </ul>
            </div>
            <div class="flex items-center gap-2">
                <div class="lg:tooltip" data-tip="Pilih untuk papar senarai warga kerja atau skop kerja">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="w-5 h-5 text-primary">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div role="tablist" class="tabs tabs-boxed">
                    <a role="tab" class="tab" @click="tabSelectIsStaff = true"
                        :class="tabSelectIsStaff && 'tab-active'">Warga Kerja</a>
                    <a role="tab" class="tab" @click="tabSelectIsStaff = false"
                        :class="tabSelectIsStaff || 'tab-active'">Skop Kerja</a>
                </div>
            </div>
        </div>

        {{-- Skop kerja --}}
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

        <h1 class="text-2xl font-bold">Unit Perkhidmatan</h1>

        <div class="flex flex-col w-full gap-2">

            {{-- <h1 class="flex items-center">
                <span x-show="tabSelectIsStaff">Senarai Warga Kerja</span>
                <span x-show="!tabSelectIsStaff">Senarai Skop Kerja</span>
            </h1> --}}
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center flex-1 max-w-lg gap-4">
                    <input type="text" placeholder="Isi carian" class="w-full input input-md input-bordered" />
                    <button class="label-text-alt link link-neutral">Clear</span>
                </div>
                <div class="flex items-center gap-4">

                    <!-- Open the modal using ID.showModal() method -->
                    <!-- button href="/bahagian/cipta" class="self-end btn btn-ghost btn-sm" onclick="my_modal_5.showModal()">
                        Laporan
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </button-->

                    <ul class="bg-white menu menu-horizontal rounded-box">
                        {{-- <li>
                            <a class="tooltip" data-tip="Cipta"
                                :href="tabSelectIsStaff ?
                                    '/bahagian/{{ $staffUnit->staffSection->id }}/unit/{{ $staffUnit->id }}/warga-kerja/cipta' :
                                    '/bahagian/{{ $staffUnit->staffSection->id }}/unit/{{ $staffUnit->id }}/skop-kerja/cipta'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>

                            </a>
                        </li> --}}
                        <li>
                            <label for="modal_edit_unit" class="tooltip" data-tip="Kemaskini"
                                :href="tabSelectIsStaff ?
                                    '/bahagian/{{ $staffUnit->staffSection->id }}/unit/{{ $staffUnit->id }}/warga-kerja/kemaskini' :
                                    '/bahagian/{{ $staffUnit->staffSection->id }}/unit/{{ $staffUnit->id }}/skop-kerja/kemaskini'">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path
                                        d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    <path
                                        d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>


                            </label>
                        </li>
                        <li>
                            <label for="modal_generate_report" class="tooltip" data-tip="Laporan">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </label>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="w-full overflow-x-auto bg-white shadow card">
            <table class="table table-sm">
                <!-- head -->
                <thead>
                    <tr x-show="tabSelectIsStaff">
                        <th></th>
                        <th>Warga Kerja</th>
                        <th>Unit</th>
                        <th></th>
                    </tr>
                    <tr x-show="!tabSelectIsStaff">
                        <th></th>
                        <th>Skop Kerja</th>
                        <th>Jumlah Pelaksanaan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody x-show="tabSelectIsStaff">
                    @foreach (App\Models\User::where('role', App\Helpers\UserRoleCodes::STAFF)->paginate(10) as $staff)
                        <tr class="hover">
                            <th>{{ $loop->iteration + $staff->currentPage * $staff->perPage }}</th>
                            <td>{{ ucfirst($staff->name) }}</td>
                            <td>{{ $staff->unit->name }}</td>
                            <td>
                                <a class="btn-primary btn btn-ghost" href="/warga-kerja/{{ $staff->id }}">
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
                <tbody x-show="!tabSelectIsStaff">
                    @foreach (App\Models\WorkScope::where('staff_unit_id', $staffUnit->id)->paginate(10) as $workScope)
                        <tr class="hover">
                            <th>{{ $loop->iteration + $workScope->currentPage * $workScope->perPage }}</th>
                            <td>{{ $workScope->title }}</td>
                            <td>{{ $workScope->workLogs()->count() }}</td>
                            <td>
                                <a class="btn-primary btn btn-ghost" href="/warga-kerja/{{ $workScope->id }}">
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
        <div class="self-end join">
            <button class="join-item btn btn-ghost">1</button>
            <button class="join-item btn btn-ghost">2</button>
            <button class="join-item btn btn-ghost btn-disabled">...</button>
            <button class="join-item btn btn-ghost">99</button>
            <button class="join-item btn btn-ghost">100</button>
        </div>

    </div>


    <!-- Edit staff unit -->
    <input type="checkbox" id="modal_edit_unit" class="modal-toggle" />
    <div class="modal" role="dialog">
        <form class="modal-box" method="POST"
            action="/bahagian/{{ $staffUnit->staffSection->id }}/unit/{{ $staffUnit->id }}">
            @method('PUT')
            @csrf
            <h3 class="text-lg font-bold">Kemaskini nama</h3>
            <input type="text" class="w-full mt-4 input-bordered input" value="{{ $staffUnit->name }}"
                placeholder="Isi nama unit" name="name">
            <div class="modal-action">
                <label for="modal_edit_unit" class="btn">Batal</label>
                <button class="btn btn-primary">Kemaskini</button>
            </div>
        </form>
    </div>


    <!-- Edit staff unit -->
    <input type="checkbox" id="modal_generate_report" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box">
            <form method="dialog" class="flex justify-between w-full mb-3">
                <h3 class="text-lg font-bold">Pilih bulan untuk jana laporan</h3>
                {{-- <label for="my_modal_6" class="btn">Close!</label> --}}
                <label for="modal_generate_report" class="btn btn-sm btn-ghost"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </label>
            </form>
            @livewire('reports.infinite-months', ['staffUnit' => $staffUnit])
        </div>
        </dialog>
</x-app-layout>
