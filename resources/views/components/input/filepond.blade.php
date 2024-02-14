<div class="w-full" x-data x-init="() => {
    const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
    post.on('addfilestart', (error, file) => {
        {{-- $refs.submitButton.disabled = true; --}}
        if (error) {
            console.log('Oh no');
            return;
        }
    });

    post.on('onprocessfiles', () => {
        {{-- $refs.submitButton.disabled = false; --}}
    });


    post.setOptions({
        allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                $wire.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress, abort)
            },
            revert: (filename, load) => {
                $wire.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
            },
        },
        allowImagePreview: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
        imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
        allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
        acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
        allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
        maxFileSize: {!! $attributes->has('maxFileSize') ? "'" . $attributes->get('maxFileSize') . "'" : 'null' !!}
    });
}">
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" wire:ignore />
</div>
