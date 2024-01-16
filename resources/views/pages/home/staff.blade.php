<x-app-layout>

    @if (auth()->user()->isStaff())
        <a href="{{ route('worklogs.create') }}" wire:link class="text-white btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    @endif
    <div class="flex flex-1 w-full gap-14">
        <livewire:home.profile-summary />

        <div class="w-full"><livewire:worklogs.rappasoft-table /></div>
    </div>
</x-app-layout>
