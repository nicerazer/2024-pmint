@php
    use App\Models\WorkLog;
    use App\Helpers\WorkLogCodes;
@endphp

<div class="w-[20rem]"><!-- Profile Section -->
    @if (auth()->user()->getMedia('avatar')->count())
        <img src="{{ auth()->user()->getFirstMediaUrl('avatar') }}" alt="Avatar"
            class="size-[16rem] mb-8 border rounded-full bg-white mx-auto object-contain">
    @else
        <div class="flex items-center justify-center text-center border rounded-full bg-slate-300 w-[16rem] h-[16rem] mx-auto">
            Tiada Gambar</div>
    @endif
    <div class="my-4 text-center">
        <h2 class="text-lg font-bold capitalize">{{ auth()->user()->name }}</h2>
        <p class="text-lg text-gray-600 capitalize">
            @if (! auth()->user()->position)
                <span class="italic text-gray-400">Jawatan belum di set</span>
            @else
                {{ auth()->user()->position }}
            @endif
        </p>
    </div>
    <a href="{{ route('profile.edit') }}" wire:navigate class="w-full btn btn-secondary btn-sm">
        <span>Kemaskini Profil</span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
            <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
        </svg>
    </a>
    <div class="divider"></div>
    <div class="w-full bg-white border stats stats-vertical">

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Semua Log Aktiviti</div>
            <div class="stat-value">{{ $worklog_count_in_a_month_by_statuses[WorkLogCodes::ALL] }}</div>
            {{-- <div class="stat-desc">Jan 1st - Feb 1st</div> --}}
        </div>

        @if(!auth()->user()->isEvaluator2())
        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                    </path>
                </svg>
            </div>
            <div class="stat-title">Log Aktivti Dibatalkan</div>
            <div class="stat-value">{{ $worklog_count_in_a_month_by_statuses[WorkLogCodes::CLOSED] }}</div>
        </div>
        @endif

    </div>
</div><!-- Profile Section -->
