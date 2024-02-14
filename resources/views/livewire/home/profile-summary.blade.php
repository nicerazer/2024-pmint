@php
    use App\Models\WorkLog;
    use App\Helpers\WorkLogCodes;
@endphp

<section class="w-[20rem]"><!-- Profile Section -->
    <img src="{{ asset('storage/placeholder-avatars/funEmoji-1702910749853.jpg') }}" alt="Avatar"
        class="w-full mb-8 border rounded-full">
    <div class="mb-4">
        <h2 class="text-lg font-bold capitalize">{{ auth()->user()->name }}</h2>
        <p class="text-lg text-gray-600 capitalize">{{ 'Pengurus Besar Khidmat Sokongan' }}</p>
    </div>
    <a href="" class="w-full btn btn-ghost">Kemaskini Profil</a>
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
            <div class="stat-value">{{ WorkLog::count(WorkLogCodes::ALL) }}</div>
            {{-- <div class="stat-desc">Jan 1st - Feb 1st</div> --}}
        </div>
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
            <div class="stat-value">{{ WorkLog::count(WorkLogCodes::CLOSED) }}</div>
        </div>


    </div>
</section><!-- Profile Section -->
