@php
use App\Helpers\WorkLogCodes;
@endphp

<div class="flex flex-col basis-5/12"> {{-- Left Side : Worklog Summary --}}
    <div class="w-full">
        <div class="flex justify-between">
            <h5>
                <span class="text-xl font-bold">{{ $workLog->workScopeTitle() }}</span>
                <span class="ml-1 font-light whitespace-nowrap">{{ '# No.' . $workLog->id }}</span>
                <x-work-logs.status-badge :row="$workLog" />
            </h5>
            <div>
                <p class="mb-1 font-bold text-right text-gray-600">Bahagian</p>
                <p class="mb-3 text-sm text-right">{{ $workLog->unit->section->name }}</p>
            </div>
        </div>

        <p class="mt-3 mb-1 font-bold text-gray-600">📝 Nota Aktiviti</p>
        <p class="mb-3 text-sm">{{ $workLog->description ? $workLog->description : 'Tiada nota' }}</p>
        <div class="divider divider-vertical"></div>
        <div class="flex justify-between my-5">
            <span class="text-gray-500">Tarikh mula</span>
            <span>{{ $workLog->created_at->format('jS M Y') }}</span>
        </div>
        {{-- @if ($workLog->isSubmitted())
        @endif
        @if ($workLog->isClosed())
        @endif --}}
        @if ($workLog->isOngoing())
            <div class="flex justify-between my-5">
                <span class="text-gray-500">Jangka Siap</span>
                <span>{{ $workLog->expected_at->format('jS M Y') }}</span>
            </div>
        @endif
        @if ($workLog->isCompleted())
            <div class="flex justify-between my-5">
                <span class="text-gray-500">Tarikh Selesai</span>
                <span>{{ $workLog->created_at->format('jS M Y') }}</span>
            </div>
        @endif
        @if ($workLog->isToRevise())
            <div class="flex justify-between my-5">
                <span class="text-gray-500">Tarikh Dikembalikan</span>
                <span>{{ $workLog->created_at->format('jS M Y') }}</span>
            </div>
        @endif
        <div class="divider divider-vertical"></div>
        {{-- @if (auth()->user()->isStaff() && $workLog->submitable())
            <button class="btn-block btn btn-primary" @click="showSubmissionBox = true">
                Hantar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 11.25a.75.75 0 0 0 1.5 0v-2.546l.943 1.048a.75.75 0 1 0 1.114-1.004l-2.25-2.5a.75.75 0 0 0-1.114 0l-2.25 2.5a.75.75 0 1 0 1.114 1.004l.943-1.048v2.546Z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        @endif --}}
        {{-- @if (auth()->user()->isEvaluator1() && $workLog->evaluatable())
            <button class="btn-block btn btn-primary" @click="showSubmissionBox = true">
                Nilai Log Aktiviti <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 11.25a.75.75 0 0 0 1.5 0v-2.546l.943 1.048a.75.75 0 1 0 1.114-1.004l-2.25-2.5a.75.75 0 0 0-1.114 0l-2.25 2.5a.75.75 0 1 0 1.114 1.004l.943-1.048v2.546Z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        @endif --}}

    </div>
    @if (auth()->user()->isEvaluator1() && in_array($workLog->status, [WorkLogCodes::ONGOING, WorkLogCodes::SUBMITTED, WorkLogCodes::TOREVISE]))
        <form action="" class="mx-auto w-72"><button class="btn btn-block btn-error btn-sm">Batal Log Aktviti</button></form>
    @endif
</div>{{-- Left Side : Worklog Summary --}}
