@php
    use Illuminate\Support\Facades\Route;
    use App\Helpers\worklogCodes;
    use App\Helpers\UserRoleCodes;
    use Carbon\Carbon;
@endphp
<div class="w-full grow">

    <div class="flex items-center justify-between gap-4 mb-4">
        <button class="mb-3 -mx-4 text-xl btn btn-ghost" type="button" onclick="select_month_modal.showModal()">
            {{ $this->selected_month->format('Y F') }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>

        </button>
        <div class="flex items-center gap-2 justify-self-end shrink-0">
            <p class="mr-6 text-gray-500">Paparan {{ $worklogs->count() * $worklogs->currentPage() }} dari
                {{ $worklogs->total() }} kerja</p>

            @if (auth()->user()->isStaff())
                <a href="{{ route('worklogs.create') }}" wire:link class="text-white btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            @endif
        </div>
    </div>

    {{-- Month picker --}}
    <dialog id="select_month_modal" class="modal">
        <div class="modal-box">
            <div class="flex justify-between w-full">
                <div class="mb-3">
                    <h3 class="flex items-end gap-3 mb-2 text-2xl font-bold">Tahun
                        <span class="inline-flex items-center self-end gap-1">
                            <button type="button" @click="$wire.subYear(); select_month_modal.close();"
                                class="btn btn-xs btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            {{ $this->selected_month->format('Y') }}
                            <button type="button" @click="$wire.addYear(); select_month_modal.close();"
                                class="btn btn-xs btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </h3>
                    <h3 class="text-lg font-bold">Pilih bulan</h3>
                </div>
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="text-gray-600 hover:text-gray-950"><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="px-2 py-1">Bulan</th>
                        <th class="px-2 py-1">Jumlah Kerja</th>
                        <th class="px-2 py-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->worklogs_in_a_month as $item)
                        <tr class="cursor-pointer hover" x-id="['monthPicker']">
                            <th class="p-0">
                                <button :id="$id('monthPicker')" type="button" class="w-full px-2 py-1 text-start"
                                    @click="$wire.setMonth('{{ $item['month'] }}'); select_month_modal.close();">{{ $item['month'] }}</button>
                            </th>
                            <td class="p-0">
                                <button :id="$id('monthPicker')" type="button" class="w-full px-2 py-1 text-start"
                                    @click="$wire.setMonth('{{ $item['month'] }}'); select_month_modal.close();">{{ $item['total'] }}</button>
                            </td>
                            <td class="p-0">
                                <button :id="$id('monthPicker')" type="button" class="w-full px-2 py-1 text-start"
                                    @click="$wire.setMonth('{{ $item['month'] }}'); select_month_modal.close();">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        {{-- <th><span class="h-60" x-intersect="$wire.loadMoreMonths()"></span></th> --}}
                        <th><span class="h-60"></span></th>
                        <td><span class="h-60"></span></td>
                        <td><span class="h-60"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    {{-- Month picker --}}


    <div class="flex items-center justify-between gap-4 mb-4">

        <input type="text" wire:model.live="search" placeholder="Cari log kerja"
            class="w-full bg-white input input-bordered" />

        <livewire:work-logs.filters.statuses-dropdown :$status_index :$worklog_counts_by_statuses />
        {{-- <livewire:work-logs.filters.statuses-dropdown :$status_index :$worklog_counts_by_statuses /> --}}

    </div>

    <div class="flex items-start w-full gap-4">

        <div class="flex flex-col grow"> <!-- Table Data -->
            <div class="w-full mb-2 overflow-x-auto bg-white border rounded-lg">

                {{-- <table>
                    <tbody>
                        @foreach ($worklogs as $worklog)
                            <tr wire:key="{{ $worklog->id }}">
                                <td>asdasd</td>
                                <x-table-partials.td-staff />
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox" />
                                </label>
                            </th>
                            @if (auth()->user()->isStaff())
                                <th>Kerja</th>
                            @else
                                <th>Kerja / Staff</th>
                            @endif
                            <th class="text-center">Status</th>
                            <th class="text-right">Tarikh Cipta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <livewire:temporary-component :worklogs="$worklogs->items()" />
                </table>
            </div>
            <div class="self-end join">
                {{-- <button class="join-item btn btn-neutral">1</button>
                <button class="join-item btn btn-neutral">2</button>
                <button class="join-item btn btn-neutral btn-disabled">...</button>
                <button class="join-item btn btn-neutral">99</button>
                <button class="join-item btn btn-neutral">100</button> --}}
                {{ $worklogs->links() }}
            </div>
        </div> <!-- Table Data -->

    </div>
    {{-- asdasd --}}
    {{-- {{ var_dump($worklogs->items()) }} --}}
    {{-- <div x-data="months()">
        <template x-for="item in items " :key="item">
            <div x-text=" item.name "></div>
            asd
        </template>
    </div> --}}
</div>
@push('scripts')
    <script>
        Alpine.data('months', () => ({
            items: {{ Js::from($worklogs->items()) }}
        }));
    </script>
@endpush
