@php
    use App\Helpers\WorkLogCodes;
    use App\Helpers\WorkLogHelper;
    use App\Models\WorkScope;
    use Illuminate\Support\Facades\Storage;

@endphp

<x-app-layout>

    <style>
        .masonry-with-columns {
            columns: 3;
            column-gap: .5rem;
        }

        .masonry-with-columns>img {
            margin: 0 1rem 1rem 0;
            display: inline-block;
            width: 100%;
            text-align: center;
            font-family: system-ui;
            font-weight: 900;
            font-size: 2rem;
        }
    </style>

    <div class="w-10/12 mx-auto text-sm breadcrumbs">
        <ul>
            <li><a href="/">Halaman Utama</a></li>
            <li>{{ $workLog->workScopeTitle() }} - No #{{ $workLog->id }}</li>
        </ul>
    </div>
    <div class="flex w-10/12 gap-16 mx-auto mt-4 pb-80" x-data="{ selectedWindowTitle: 'showWorkLog', isEditing: false, showSubmissionBox: false }"> <!-- main container -->


        <livewire:work-logs.show.summary-window :$workLog />

        <livewire:work-logs.show.submission-window :$workLog />
        {{--
        @push('scripts')
            <script type="module">
                // Get a reference to the file input element
                const uploadElement = document.getElementById('file-upload');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const workLogId = {{ $workLog->id }};

                // Create a FilePond instance
                const pond = FilePond.create(uploadElement, {
                    allowMultiple: true,
                    server: {
                        // process:
                        url: `/temporary-uploads`,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    },
                    imageValidateSizeMaxWidth: 10000,
                    imageValidateSizeMaxHeight: 10000,
                    acceptedFileTypes: [
                        'image/*',
                        'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/x-7z-compressed', 'application/vnd.rar',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ],
                    imagePreviewMaxHeight: 100
                });
                pond.on('processfile', (error, file) => {
                    if (error) {
                        console.log('Processing file issue');
                        return;
                    }
                    $wire.addFile(file.serverId);
                    console.log('File processed', file);
                });
            </script>
        @endpush --}}

</x-app-layout>
