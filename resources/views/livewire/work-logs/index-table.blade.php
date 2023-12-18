@php
    use App\Helpers\WorkLogHelper;
    use Carbon\Carbon;
@endphp
<div>

    <div class="flex items-center justify-between gap-4 mb-4">
        <div class="flex items-center gap-4 justify-self-start">
            {{-- <input type="month" wire:model.live="selected_month" class="bg-white input input-bordered w-80 shrink-0" /> --}}
            <button class="align-middle btn btn-neutral w-80 shrink-0" type="button"
                onclick="select_month_modal.showModal()">
                {{ $this->selected_month->format('Y F') }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 ml-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
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
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6">
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
                                        <button :id="$id('monthPicker')" type="button"
                                            class="w-full px-2 py-1 text-start"
                                            @click="$wire.setMonth('{{ $item['month'] }}'); select_month_modal.close();">{{ $item['month'] }}</button>
                                    </th>
                                    <td class="p-0">
                                        <button :id="$id('monthPicker')" type="button"
                                            class="w-full px-2 py-1 text-start"
                                            @click="$wire.setMonth('December 2023'); select_month_modal.close();">{{ $item['total'] }}</button>
                                    </td>
                                    <td class="p-0">
                                        <button :id="$id('monthPicker')" type="button"
                                            class="w-full px-2 py-1 text-start"
                                            @click="$wire.setMonth('December 2023'); select_month_modal.close();">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5">
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
            {{-- <input type="month" value="{{ $selected_month->format('Y-m') }}" wire:model.live="month"
                class="bg-white input input-bordered w-80 shrink-0" /> --}}
            <input type="text" wire:model.live="search" placeholder="Cari log kerja"
                class="bg-white input input-bordered w-[24rem]" />
        </div>
        <div class="flex items-center gap-2 justify-self-end">
            <p class="mr-6 text-gray-500">Paparan {{ $workLogs->count() * $workLogs->currentPage() }} dari
                {{ $workLogs->total() }} kerja</p>

            @if (auth()->user()->isStaff())
                <a href="{{ route('workLogs.create') }}" wire:link class="text-white btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <div class="flex items-start gap-4">

        {{--
          ONGOING   0
          SUBMITTED 1
          TOREVISE  2
          COMPLETED 3
          CLOSED  4
        --}}
        <div class="overflow-hidden bg-white border rounded-lg w-80 shrink-0" x-data="{ status: 0 }">
            <button wire:click="selectStatus('{{ WorkLogHelper::ALL }}')" @click="status = {{ WorkLogHelper::ALL }}"
                :class="status == -1 ? 'btn-primary text-white' : 'btn-ghost'"
                class="w-full font-normal capitalize rounded-none btn">
                <span class="mr-auto">Semua</span>
                <div class="ml-auto badge" :class="status == -1 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogHelper::ALL] }}</div>
            </button>
            <button wire:click="selectStatus('{{ WorkLogHelper::ONGOING }}')"
                @click="status = {{ WorkLogHelper::ONGOING }}"
                :class="status == 0 ? 'btn-primary text-white' : 'btn-ghost'"
                class="w-full font-normal capitalize rounded-none btn">
                <span class="mr-auto">Berjalan</span>
                <div class="ml-auto badge" :class="status == 0 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogHelper::ONGOING] }}</div>
            </button>
            <button wire:click="selectStatus('{{ WorkLogHelper::SUBMITTED }}')"
                @click="status = {{ WorkLogHelper::SUBMITTED }}"
                :class="status == 1 ? 'btn-primary text-white' : 'btn-ghost'"
                class="w-full font-normal capitalize rounded-none btn">
                <span class="mr-auto">Telah Hantar</span>
                <div class="ml-auto badge" :class="status == 1 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogHelper::SUBMITTED] }}</div>
            </button>
            <button wire:click="selectStatus('{{ WorkLogHelper::TOREVISE }}')"
                @click="status = {{ WorkLogHelper::TOREVISE }}"
                :class="status == 2 ? 'btn-primary text-white' : 'btn-ghost'"
                class="w-full font-normal capitalize rounded-none btn">
                <span class="mr-auto">Ditolak</span>
                <div class="ml-auto badge" :class="status == 2 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogHelper::TOREVISE] }}</div>
            </button>
            <button wire:click="selectStatus('{{ WorkLogHelper::COMPLETED }}')"
                @click="status = {{ WorkLogHelper::COMPLETED }}"
                :class="status == 3 ? 'btn-primary text-white' : 'btn-ghost'"
                class="w-full font-normal capitalize rounded-none btn">
                <span class="mr-auto">Selesai</span>
                <div class="ml-auto badge" :class="status == 3 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogHelper::COMPLETED] }}</div>
            </button>
            <button wire:click="selectStatus('{{ WorkLogHelper::CLOSED }}')"
                @click="status = {{ WorkLogHelper::CLOSED }}"
                :class="status == 4 ? 'btn-primary text-white' : 'btn-ghost'"
                class="w-full font-normal capitalize rounded-none btn">
                <span class="mr-auto">Ditutup</span>
                <div class="ml-auto badge" :class="status == 4 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogHelper::CLOSED] }}</div>
            </button>
        </div>
        <div class="flex flex-col w-full">
            <div class="w-full mb-2 overflow-x-auto bg-white border rounded-lg">
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
                    <tbody>
                        @foreach ($workLogs as $workLog)
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox" />
                                    </label>
                                </th>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <div wire:key="{{ $workLog->id }}" class="font-bold">
                                                {{ $workLog->workscope->title }}
                                            </div>
                                            @if (auth()->user()->isStaff())
                                                <div class="text-sm opacity-50">{{ $workLog->author->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <x-work-logs.status-badge :worklog='$workLog' />
                                </td>
                                <td class="text-right">
                                    <span>12 Nov, 2023</span><br>
                                    <span>11:40pm</span>
                                </td>
                                <th class="flex justify-end">
                                    {{-- <button class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button> --}}

                                    {{-- If evaluators they can just approve, there is a button, rating option, and comment box --}}
                                    {{-- If staffs they can submit here.. Maybe? What about file uploads? --}}

                                    {{-- <button class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                        </svg>
                                    </button> --}}
                                    {{-- <div class="divider-vertical"></div> <!-- idk lol try look at it first --> --}}
                                    <a class="btn btn-ghost" href="/logkerja/{{ $workLog->id }}" wire:navigate>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="self-end join">
                {{-- <button class="join-item btn btn-neutral">1</button>
                <button class="join-item btn btn-neutral">2</button>
                <button class="join-item btn btn-neutral btn-disabled">...</button>
                <button class="join-item btn btn-neutral">99</button>
                <button class="join-item btn btn-neutral">100</button> --}}
                {{ $workLogs->links() }}
            </div>
        </div>

    </div>
</div>
