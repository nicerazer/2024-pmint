@php
    use App\Models\WorkLog;
    use App\Helpers\WorkLogCodes;
    use Illuminate\Support\Facades\Log;
@endphp

{{--
    <a href="{{ route('worklogs.create') }}" wire:link class="text-white btn btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </a> --}}
<div class="flex flex-1 w-full gap-14">
    {{-- @php
        Log::debug($worklog_count_in_a_month_by_statuses);
    @endphp --}}
    <div><livewire:home.profile-summary :$worklog_count_in_a_month_by_statuses /></div>

    <div class="w-full overflow-hidden">
        <livewire:home.stats-summary :$worklog_count_in_a_month_by_statuses />

        <livewire:worklogs.rappasoft-table :$selected_month />
    </div>
</div>
