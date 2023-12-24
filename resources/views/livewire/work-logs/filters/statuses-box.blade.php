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
@endphp

<div class="overflow-hidden bg-white border rounded-lg w-80 shrink-0" x-data="{ status: 0 }">
    <button wire:click="selectStatus('{{ WorkLogCodes::ALL }}')" @click="status = {{ WorkLogCodes::ALL }}"
        :class="status == -1 ? 'btn-primary text-white' : 'btn-ghost'"
        class="w-full font-normal capitalize rounded-none btn">
        <span class="mr-auto">Semua</span>
        <div class="ml-auto badge" :class="status == -1 ? ' badge-accent' : ''">
            {{ $workLog_by_statuses_count[WorkLogCodes::ALL] }}</div>
    </button>
    <button wire:click="selectStatus('{{ WorkLogCodes::ONGOING }}')" @click="status = {{ WorkLogCodes::ONGOING }}"
        :class="status == 0 ? 'btn-primary text-white' : 'btn-ghost'"
        class="w-full font-normal capitalize rounded-none btn">
        <span class="mr-auto">Berjalan</span>
        <div class="ml-auto badge" :class="status == 0 ? ' badge-accent' : ''">
            {{ $workLog_by_statuses_count[WorkLogCodes::ONGOING] }}</div>
    </button>
    <button wire:click="selectStatus('{{ WorkLogCodes::SUBMITTED }}')" @click="status = {{ WorkLogCodes::SUBMITTED }}"
        :class="status == 1 ? 'btn-primary text-white' : 'btn-ghost'"
        class="w-full font-normal capitalize rounded-none btn">
        <span class="mr-auto">Telah Hantar</span>
        <div class="ml-auto badge" :class="status == 1 ? ' badge-accent' : ''">
            {{ $workLog_by_statuses_count[WorkLogCodes::SUBMITTED] }}</div>
    </button>
    <button wire:click="selectStatus('{{ WorkLogCodes::TOREVISE }}')" @click="status = {{ WorkLogCodes::TOREVISE }}"
        :class="status == 2 ? 'btn-primary text-white' : 'btn-ghost'"
        class="w-full font-normal capitalize rounded-none btn">
        <span class="mr-auto">Ditolak</span>
        <div class="ml-auto badge" :class="status == 2 ? ' badge-accent' : ''">
            {{ $workLog_by_statuses_count[WorkLogCodes::TOREVISE] }}</div>
    </button>
    <button wire:click="selectStatus('{{ WorkLogCodes::COMPLETED }}')" @click="status = {{ WorkLogCodes::COMPLETED }}"
        :class="status == 3 ? 'btn-primary text-white' : 'btn-ghost'"
        class="w-full font-normal capitalize rounded-none btn">
        <span class="mr-auto">Selesai</span>
        <div class="ml-auto badge" :class="status == 3 ? ' badge-accent' : ''">
            {{ $workLog_by_statuses_count[WorkLogCodes::COMPLETED] }}</div>
    </button>
    <button wire:click="selectStatus('{{ WorkLogCodes::CLOSED }}')" @click="status = {{ WorkLogCodes::CLOSED }}"
        :class="status == 4 ? 'btn-primary text-white' : 'btn-ghost'"
        class="w-full font-normal capitalize rounded-none btn">
        <span class="mr-auto">Ditutup</span>
        <div class="ml-auto badge" :class="status == 4 ? ' badge-accent' : ''">
            {{ $workLog_by_statuses_count[WorkLogCodes::CLOSED] }}</div>
    </button>
</div>
