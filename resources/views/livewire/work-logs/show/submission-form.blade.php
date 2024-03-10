<div class="relative">
    <div class="absolute z-10 justify-center hidden w-full gap-4 mx-auto mt-36" wire:loading.class="!flex"
        wire:target="save">
        <h3 class="text-lg font-semibold">Sedang Diproses </h3>
        <span class="loading loading-dots loading-md"></span>
    </div>

    <div class="flex card-body" wire:loading.class="blur" wire:target="save">

        <h3 class="mb-2 font-bold text-gray-800">Hantar Kerja</h3>
        <form wire:submit="save">
            <div class="mb-2">
                <h2 class="mb-1">Nota</h2>
                <textarea type="text" wire:model="body" class="w-full textarea textarea-bordered"></textarea>
                @error('body')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
                {{-- <div x-show="uploading">Uploading...</div> --}}

            </div>
            <div class="mb-2" wire:ignore>
                <x-input.filepond wire:model="attachments" multiple allowImagePreview imagePreviewMaxHeight="200"
                    allowFileTypeValidation
                    acceptedFileTypes="[
                        'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
                        'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/rtf', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'application/gzip', 'application/pdf', 'application/vnd.rar', 'application/zip', 'application/x-7z-compressed'
                    ]"
                    allowFileSizeValidation maxFileSize="100mb" />
                @error('attachments')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button class="btn-block btn btn-primary" x-ref="submitButton" wire:ignore>
                Hantar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 11.25a.75.75 0 0 0 1.5 0v-2.546l.943 1.048a.75.75 0 1 0 1.114-1.004l-2.25-2.5a.75.75 0 0 0-1.114 0l-2.25 2.5a.75.75 0 1 0 1.114 1.004l.943-1.048v2.546Z"
                        clip-rule="evenodd" />
                </svg>
            </button>

        </form>
    </div>
</div>
