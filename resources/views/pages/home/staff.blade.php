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
            <livewire:home.stats-summary />

            <livewire:worklogs.rappasoft-table />
        </div>
    </div>
</x-app-layout>
