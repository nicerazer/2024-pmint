<div x-data="{ expanded: false }">
    <div class="flex items-center justify-between gap-4 mb-3">
        @php $images = $submission->getMedia('images') @endphp
        <h3 @click="expanded = ! expanded"
            class="text-lg font-bold @if ($submission->evaluated_at && $submission->is_accept) text-slate-600 @endif">
            Gambar-gambar
            <div class="ml-1 text-white badge badge-neutral">{{ $images->count() }}</div>

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
            wire:click="downloadImages()">
            Muat Turun Semua
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd"
                    d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div class="transition-all masonry-with-columns" :class="expanded && 'mb-8'" x-show="expanded" x-collapse>
        @foreach ($images as $image)
            <div class="p-1 border h-fit rounded-xl bg-slate-100 border-slate-200">
                <div class="relative rounded-lg overflow-clip group" wire:click="downloadImage({{ $image->id }})">
                    <div
                        class="absolute z-10 w-full h-full transition-opacity duration-200 ease-in-out bg-black opacity-0 group-hover:opacity-60">
                    </div>

                    <img src="{{ $image->getUrl() }}"
                        class="w-full transition-transform duration-200 ease-in-out group-hover:scale-125">

                </div>
            </div>
        @endforeach
    </div>
</div>
