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

        <div class="flex flex-col basis-5/12"> {{-- Left Side : Worklog Summary --}}
            <div class="w-full">
                <div class="flex justify-between">
                    <h5>
                        <span class="text-xl font-bold">{{ $workLog->workScopeTitle() }}</span>
                        <span class="ml-1 font-light">{{ '# No.' . $workLog->id }}</span>
                    </h5>
                    <label for="my_modal_7" class="link link-primary" @click="isEditing = true">Kemaskini</label>
                    <input type="checkbox" id="my_modal_7" class="modal-toggle" />
                    <!-- Edit Worklog -->
                    <div class="modal" role="dialog" x-show="isEditing">
                        <form class="w-11/12 max-w-5xl modal-box" action="/logkerja/{{ $workLog->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <h3 class="text-lg font-bold">Kemaskini</h3>
                            <div class="w-full">
                                <div class="flex mt-8">
                                    <div class="w-52">
                                        <h4 class="w-52">Skop Kerja</h4>
                                    </div>
                                    <div class="grow">
                                        <select class="w-full border-gray-300 select " wire:model="work_scope_id">
                                            <option disabled selected value="">Pilih kerja</option>
                                            @foreach (WorkScope::all() as $workScope)
                                                <option value="{{ $workScope->id }}"
                                                    @if ($workLog->workscope->id == $workScope->id) selected @endif>
                                                    {{ $workScope->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex mt-8">
                                    <div class="w-52">
                                        <h4 class="w-52">Nota</h4>
                                    </div>
                                    <div class="grow">
                                        <textarea wire:model="description" placeholder="Keterangan..." class="w-full textarea textarea-bordered" rows="5">{{ $workLog->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-action">
                                <label for="my_modal_7" class="btn btn-ghost">Batal</label>
                                <button class="btn btn-primary">Kemaskini</button>
                            </div>
                        </form>
                        <label class="modal-backdrop" for="my_modal_7">Close</label>
                    </div> <!-- Edit Worklog -->
                </div>
                <x-work-logs.status-badge :$workLog />
                <p class="mt-3 font-bold text-gray-600">Penjelasan Aktiviti</p>
                <p class="mt-3">{{ $workLog->description }}</p>
                <div class="divider divider-vertical"></div>
                <div class="flex justify-between my-5">
                    <span class="text-gray-500">Tarikh mula</span>
                    <span>{{ $workLog->created_at->format('jS M Y') }}</span>
                </div>
                <div class="flex justify-between my-5">
                    <span class="text-gray-500">Jangka Siap</span>
                    <span>{{ $workLog->expected_at->format('jS M Y') }}</span>
                </div>
                <div class="flex justify-between my-5">
                    <span class="text-gray-500">Tarikh Selesai</span>
                    <span>{{ $workLog->created_at->format('jS M Y') }}</span>
                </div>
                <div class="flex justify-between my-5">
                    <span class="text-gray-500">Tarikh Terima</span>
                    <span>{{ $workLog->created_at->format('jS M Y') }}</span>
                </div>
                <div class="divider divider-vertical"></div>
                @if (auth()->user()->isStaff() && $workLog->submitable())
                    <button class="btn-block btn btn-primary" @click="showSubmissionBox = true">
                        Hantar <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 11.25a.75.75 0 0 0 1.5 0v-2.546l.943 1.048a.75.75 0 1 0 1.114-1.004l-2.25-2.5a.75.75 0 0 0-1.114 0l-2.25 2.5a.75.75 0 1 0 1.114 1.004l.943-1.048v2.546Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
                @if (auth()->user()->isEvaluator1() && $workLog->evaluatable())
                    <button class="btn-block btn btn-primary" @click="showSubmissionBox = true">
                        Nilai Log Aktiviti <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 11.25a.75.75 0 0 0 1.5 0v-2.546l.943 1.048a.75.75 0 1 0 1.114-1.004l-2.25-2.5a.75.75 0 0 0-1.114 0l-2.25 2.5a.75.75 0 1 0 1.114 1.004l.943-1.048v2.546Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif

            </div>
        </div>{{-- Left Side : Worklog Summary --}}

        <div class="flex flex-col gap-8 basis-7/12"> {{-- Right Side : Submissions --}}

            <div class="w-full bg-white shadow-lg card" x-show="true" x-transition>
                @if (auth()->user()->isStaff() && $workLog->submitable())
                    <livewire:work-logs.show.submission-form :worklog="$workLog" />
                @endif
                @if (auth()->user()->isEvaluator1() && $workLog->evaluatable())
                    <livewire:work-logs.show.evaluation-form :submission="$workLog->latestSubmission" />
                @endif
            </div>
            <livewire:work-logs.show.submissions :$workLog />

            <div class="relative">
                @unless ($workLog->submitted_at && ($workLog->level_1_accepted_at || $workLog->level_2_accepted_at))
                    {{-- Update --}}
                    @unless ($workLog->submitted_at)
                        <div class="w-full" x-show="selectedWindowTitle == 'editWorkLog'" x-transition>
                            <div class="flex mt-8">
                                <div class="w-52">
                                    <h4 class="w-52">Skop Kerja</h4>
                                </div>
                                <div class="grow">
                                    <select class="w-full border-gray-300 select " wire:model="work_scope_id">
                                        <option disabled selected value="">Pilih kerja</option>
                                        @foreach (WorkScope::all() as $workScope)
                                            <option value="{{ $workScope->id }}"
                                                @if ($workLog->workscope->id == $workScope->id) selected @endif>
                                                {{ $workScope->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex mt-8">
                                <div class="w-52">
                                    <h4 class="w-52">Status</h4>
                                </div>
                                <div>
                                    <h5>
                                        <x-work-logs.status-badge :$workLog />
                                    </h5>
                                </div>
                            </div>
                            <div class="flex mt-8">
                                <div class="w-52">
                                    <h4 class="w-52">Penilaian</h4>
                                </div>
                                <div>
                                    <h5>{{ $workLog->rating }}</h5>
                                </div>
                            </div>
                            <div class="flex mt-8">
                                <div class="w-52">
                                    <h4 class="w-52">Nota</h4>
                                </div>
                                <div class="grow">
                                    <textarea wire:model="description" placeholder="Keterangan..." class="w-full textarea textarea-bordered"
                                        rows="5">{{ $workLog->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endunless

                @endunless
            </div>

        </div> <!-- main container -->

        @push('scripts')
            {{-- <script type="module">
            // Get a reference to the file input element
            const inputElement = document.querySelector('input[type="file"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);
        </script> --}}

            <script type="module">
                // Get a reference to the file input element
                const imageUploadElement = document.getElementById('file-upload');
                const documentUploadElement = document.querySelector('#document-upload');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const workLogId = {{ $workLog->id }};

                // Create a FilePond instance
                const pondImages = FilePond.create(imageUploadElement, {
                    allowMultiple: true,
                    server: {
                        url: `/temporary-uploads`,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    },
                    // labelIdle: 'Tarik & Letak <span class="font-bold">gambar</span> atau <span class="filepond--label-action"> Buka Carian </span>',
                    imageValidateSizeMaxWidth: 10000,
                    imageValidateSizeMaxHeight: 10000,
                    // maxFileSize: 10000000,
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

                // const pondDocuments = FilePond.create(documentUploadElement, {
                //     server: 'workLogs/1/documents',
                //     labelIdle: 'Drag & Drop your <span class="font-bold">documents</span> or <span class="filepond--label-action"> Browse </span>',
                //     maxFileSize: 50000000,
                //     acceptedFileTypes: [
                //         'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                //         'application/x-7z-compressed', 'application/vnd.rar',
                //         'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                //         'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword',
                //         'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                //     ],
                // });
            </script>
        @endpush
</x-app-layout>
