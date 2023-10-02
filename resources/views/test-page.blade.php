<x-app-layout>

    {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}


    <div class="w-96">
        <input type="file" id="image-uploads" />
        <input type="file" id="document-uploads" />
    </div>



    {{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}
    @push('scripts')
        <script type="module">
            // Get a reference to the file input element
            const inputElement = document.querySelector('#image-uploads');
            const inputElement = document.querySelector('#document-uploads');

            // Create a FilePond instance
            const pondImages = FilePond.create(inputElement, {
                labelIdle: 'Drag & Drop your images or <span class="filepond--label-action"> Browse </span>',
                imageValidateSizeMaxWidth: 80,
                imageValidateSizeMaxHeight: 80,
                maxFileSize: 30 mb,
                fileRenameFunction: (file) => {
                    return `my_new_name${file.extension}`;
                },
                acceptedFileTypes: ['image/*', ],
            });

            const pondDocuments = FilePond.create(inputElement, {
                labelIdle: 'Drag & Drop your documents or <span class="filepond--label-action"> Browse </span>',
                maxFileSize: 300 mb,
                fileRenameFunction: (file) => {
                    return `my_new_name${file.extension}`;
                },
                acceptedFileTypes: [
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/x-7z-compressed',
                    'application/vnd.rar',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/vnd.ms-powerpoint',
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                ],
            });
        </script>
    @endpush
</x-app-layout>
