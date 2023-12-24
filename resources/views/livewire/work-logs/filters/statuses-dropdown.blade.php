@php
    use App\Helpers\WorkLogCodes;
    $workLog_by_statuses_count = [
        -1 => 10,
        0 => 10,
        1 => 10,
        2 => 10,
        3 => 10,
        4 => 10,
    ];
    $translate = WorkLogCodes::TRANSLATION[2];

@endphp

<div class="dropdown dropdown-end shrink-0" x-data="{ status: 0 }">
    <div tabindex="0" role="button" class="m-1 btn btn-neutral">
        <span x-text="{{ json_encode(WorkLogCodes::TRANSLATION) }}[status]"></span>
        <div class="ml-auto badge badge-accent">
            {{ $workLog_by_statuses_count[WorkLogCodes::SUBMITTED] }}</div>
        {{--
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            data-slot="icon" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg> --}}

    </div>
    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
        <li><button wire:click="$dispatch('select-status', {selected_status_index: '{{ WorkLogCodes::ALL }}'})"
                @click="status = {{ WorkLogCodes::ALL }}" :class="status == -1 && 'active'">
                <span class="mr-auto">Semua</span>
                <div class="ml-auto badge" :class="status == -1 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogCodes::ALL] }}</div>
            </button></li>
        <li><button wire:click="$dispatch('select-status', {selected_status_index: '{{ WorkLogCodes::ONGOING }}'})"
                @click="status = {{ WorkLogCodes::ONGOING }}" :class="status == 0 && 'active'">
                <span class="mr-auto">Dalam Tindakan</span>
                <div class="ml-auto badge" :class="status == 0 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogCodes::ONGOING] }}</div>
            </button></li>
        <li><button wire:click="$dispatch('select-status', {selected_status_index: '{{ WorkLogCodes::SUBMITTED }}'})"
                @click="status = {{ WorkLogCodes::SUBMITTED }}" :class="status == 1 && 'active'">
                <span class="mr-auto">Sedang Dinilai</span>
                <div class="ml-auto badge" :class="status == 1 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogCodes::SUBMITTED] }}</div>
            </button></li>
        <li><button wire:click="$dispatch('select-status', {selected_status_index: '{{ WorkLogCodes::TOREVISE }}'})"
                @click="status = {{ WorkLogCodes::TOREVISE }}" :class="status == 2 && 'active'">
                <span class="mr-auto">Kembali</span>
                <div class="ml-auto badge" :class="status == 2 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogCodes::TOREVISE] }}</div>
            </button></li>
        <li><button wire:click="$dispatch('select-status', {selected_status_index: '{{ WorkLogCodes::COMPLETED }}'})"
                @click="status = {{ WorkLogCodes::COMPLETED }}" :class="status == 3 && 'active'">
                <span class="mr-auto">Selesai</span>
                <div class="ml-auto badge" :class="status == 3 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogCodes::COMPLETED] }}</div>
            </button></li>
        <li><button wire:click="$dispatch('select-status', {selected_status_index: '{{ WorkLogCodes::CLOSED }}'})"
                @click="status = {{ WorkLogCodes::CLOSED }}" :class="status == 4 && 'active'">
                <span class="mr-auto">Batal</span>
                <div class="ml-auto badge" :class="status == 4 ? ' badge-accent' : ''">
                    {{ $workLog_by_statuses_count[WorkLogCodes::CLOSED] }}</div>
            </button></li>
    </ul>
</div>
