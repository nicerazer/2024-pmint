@php
    use App\Models\WorkLog;
    use App\Helpers\WorkLogCodes;
@endphp

<x-app-layout>
    {{--
    <a href="{{ route('worklogs.create') }}" wire:link class="text-white btn btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </a> --}}
    <div class="flex flex-1 w-full gap-14">
        <livewire:home.profile-summary />

        <div class="w-full overflow-hidden">
            <div class="w-full mb-3 shadow stats">

                @if (auth()->user()->isEvaluator2())
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Belum Disahkan (Penilai 1)</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::NOTYETEVALUATED) }}</div>
                        {{-- <div class="stat-desc">Jan 1st - Feb 1st</div> --}}
                    </div>

                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Boleh Sah</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::COMPLETED) }}</div>
                        {{-- <div class="stat-desc">Jan 1st - Feb 1st</div> --}}
                    </div>

                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Telah Disahkan (Penilai 2)</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::REVIEWED) }}</div>
                        {{-- <div class="stat-desc">Jan 1st - Feb 1st</div> --}}
                    </div>
                @else
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Berjalan</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::ONGOING) }}</div>
                        {{-- <div class="stat-desc">Jan 1st - Feb 1st</div> --}}
                    </div>

                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block w-8 h-8 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <div class="stat-title">Untuk Penilaian</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::SUBMITTED) }}</div>
                        {{-- <div class="stat-desc">↗︎ 400 (22%)</div> --}}
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
                        <div class="stat-title">Dikembalikan</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::TOREVISE) }}</div>
                        {{-- <div class="stat-desc">↘︎ 90 (14%)</div> --}}
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
                        <div class="stat-title">Selesai</div>
                        <div class="stat-value">{{ WorkLog::count(WorkLogCodes::COMPLETED) }}</div>
                    </div>
                @endif
            </div>
            <livewire:worklogs.rappasoft-table />
        </div>
    </div>
</x-app-layout>
