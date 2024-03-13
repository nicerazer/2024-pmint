<div x-data="{ expanded: false }"> <!-- Dokumen -->
    <div class="flex items-center justify-between gap-4 mb-3" @click="expanded = ! expanded">
        @php $documents = $submission->getMedia('documents') @endphp

        <h3 class="text-lg font-bold @if ($submission->evaluated_at && $submission->is_accept) text-slate-600 @endif">
            Dokumen-dokumen
            <div class="ml-1 text-white badge badge-neutral">{{ $documents->count() }}</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="inline w-5 h-5 transition-transform" :class="expanded && 'rotate-180'">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
            </svg>
        </h3>
        <button
            class="ml-2 btn btn-sm
                @if ($submission->evaluated_at && !$submission->is_accept) btn-neutral
                @elseif ($submission->evaluated_at && $submission->is_accept) btn-outline
                @else btn-ghost @endif"
            wire:click="downloadDocuments()">
            Muat Turun Semua
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd"
                    d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div class="flex flex-wrap w-full gap-4" x-show="expanded" x-collapse>
        @if ($submission->workLog->submitted_at)
        @endif
        @foreach ($documents as $document)
            <div class="flex items-center gap-1 pl-2 pr-4 border rounded-lg bg-slate-50">
                <div class="flex flex-row items-center justify-center gap-4">
                    <button type="button" class="btn btn-circle btn-ghost btn-sm"
                        wire:click="downloadDocument({{ $document->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                            <path
                                d="M8.75 2.75a.75.75 0 0 0-1.5 0v5.69L5.03 6.22a.75.75 0 0 0-1.06 1.06l3.5 3.5a.75.75 0 0 0 1.06 0l3.5-3.5a.75.75 0 0 0-1.06-1.06L8.75 8.44V2.75Z" />
                            <path
                                d="M3.5 9.75a.75.75 0 0 0-1.5 0v1.5A2.75 2.75 0 0 0 4.75 14h6.5A2.75 2.75 0 0 0 14 11.25v-1.5a.75.75 0 0 0-1.5 0v1.5c0 .69-.56 1.25-1.25 1.25h-6.5c-.69 0-1.25-.56-1.25-1.25v-1.5Z" />
                        </svg>
                    </button>
                    <div class="-ml-2 rounded badge badge-ghost badge-xs text-nowrap">
                        {{ $document->human_readable_size }}</div>
                    <span>{{ $document->name }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div> <!-- Dokumen -->
