@php
    use App\Helpers\WorkLogHelper;
    use Carbon\Carbon;
@endphp

<div class="flex items-start gap-4">

    {{--
      ONGOING   0
      SUBMITTED 1
      TOREVISE  2
      COMPLETED 3
      CLOSED  4
    --}}
    <div class="overflow-hidden bg-white border rounded-lg w-80" x-data="{ status: 0 }">
        <button wire:click="selectStatus('-1')" @click="status = -1" :class="status == -1 ? 'btn-primary' : 'btn-ghost'"
            class="w-full font-normal capitalize rounded-none btn">
            <span class="mr-auto">Semua</span>
            <div class="ml-auto badge badge-neutral">{{ $workLog_by_statuses_count[WorkLogHelper::ALL] }}</div>
        </button>
        <button wire:click="selectStatus('0')" @click="status = 0" :class="status == 0 ? 'btn-primary' : 'btn-ghost'"
            class="w-full font-normal capitalize rounded-none btn">
            <span class="mr-auto">Berjalan</span>
            <div class="ml-auto badge">{{ $workLog_by_statuses_count[WorkLogHelper::ONGOING] }}</div>
        </button>
        <button wire:click="selectStatus('1')" @click="status = 1" :class="status == 1 ? 'btn-primary' : 'btn-ghost'"
            class="w-full font-normal capitalize rounded-none btn">
            <span class="mr-auto">Telah Hantar</span>
            <div class="ml-auto badge">{{ $workLog_by_statuses_count[WorkLogHelper::SUBMITTED] }}</div>
        </button>
        <button wire:click="selectStatus('2')" @click="status = 2" :class="status == 2 ? 'btn-primary' : 'btn-ghost'"
            class="w-full font-normal capitalize rounded-none btn">
            <span class="mr-auto">Dikembalikan</span>
            <div class="ml-auto badge">{{ $workLog_by_statuses_count[WorkLogHelper::TOREVISE] }}</div>
        </button>
        <button wire:click="selectStatus('3')" @click="status = 3" :class="status == 3 ? 'btn-primary' : 'btn-ghost'"
            class="w-full font-normal capitalize rounded-none btn">
            <span class="mr-auto">Selesai</span>
            <div class="ml-auto badge">{{ $workLog_by_statuses_count[WorkLogHelper::COMPLETED] }}</div>
        </button>
        <button wire:click="selectStatus('4')" @click="status = 4" :class="status == 4 ? 'btn-primary' : 'btn-ghost'"
            class="w-full font-normal capitalize rounded-none btn">
            <span class="mr-auto">Ditutup</span>
            <div class="ml-auto badge">{{ $workLog_by_statuses_count[WorkLogHelper::CLOSED] }}</div>
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
                        <th>Staff / Kerja</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Tarikh Cipta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
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
                                        <div class="font-bold">{{ $workLog->author->name }}</div>
                                        <div class="text-sm opacity-50">{{ $workLog->workscope->title }}</div>
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
                                <button class="btn btn-ghost">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                    </svg>
                                </button>
                                <a class="btn btn-ghost" href="/logkerja/{{ $workLog->id }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
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
