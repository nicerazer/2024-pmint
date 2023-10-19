<x-app-layout>

    {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}


    <div class="w-96">
        <input name="image-upload" type="file" id="image-upload" />
        <input name="document-upload" type="file" id="document-upload" />

    </div>



    {{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}
    @push('scripts')
        <script type="module">
            // Get a reference to the file input element
            const imageUploadElement = document.getElementById('image-upload');
            const documentUploadElement = document.querySelector('#document-upload');

            // Create a FilePond instance
            const pondImages = FilePond.create(imageUploadElement, {
                allowMultiple: true,
                server: {
                    process: {
                        url: './workLogs/124/images',
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                        },
                    },
                },
                labelIdle: 'Drag & Drop your <span class="font-bold">images</span> or <span class="filepond--label-action"> Browse </span>',
                imageValidateSizeMaxWidth: 10000,
                imageValidateSizeMaxHeight: 10000,
                maxFileSize: 10000000,
                acceptedFileTypes: 'image/*',
            });

            const pondDocuments = FilePond.create(documentUploadElement, {
                server: 'workLogs/1/documents',
                labelIdle: 'Drag & Drop your <span class="font-bold">documents</span> or <span class="filepond--label-action"> Browse </span>',
                maxFileSize: 50000000,
                acceptedFileTypes: [
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/x-7z-compressed', 'application/vnd.rar',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ],
            });
        </script>
    @endpush
</x-app-layout>
