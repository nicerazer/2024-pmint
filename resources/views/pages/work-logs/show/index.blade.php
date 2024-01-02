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

    <div class="flex w-10/12 gap-16 mx-auto mt-4 pb-80" x-data="{ selectedWindowTitle: 'showWorkLog', isEditing: false }"> <!-- main container -->

        <div class="flex flex-col basis-5/12"> {{-- Left Side : Worklog Summary --}}
            <div class="flex items-start justify-between">
                <div>
                    {{-- Worklog Title --}}
                    <h1 class="text-2xl font-bold" x-show="selectedWindowTitle == 'showWorkLog'">
                        {{ $workLog->workScopeName }}</h1>
                    {{-- <h1 class="text-2xl font-bold" x-show="selectedWindowTitle == 'editWorkLog'">Kemaskini Kerja</h1>
                    <h1 class="text-2xl font-bold" x-show="selectedWindowTitle == 'submitWorkLog'">Hantar Kerja</h1> --}}
                    <h2>No.{{ $workLog->id }}</h2>
                    <div class="w-10 h-1 mt-2 rounded-lg bg-primary"></div>
                </div>
                @if ($workLog->updated_at->notEqualTo($workLog->created_at) || true)
                    {{-- Worklog Has Edited Will Show edited at --}}
                    <p class="flex items-center gap-2 text-sm text-gray-400 w-52">
                        <span class="shrink">Dikemaskini pada {{ $workLog->updated_at->format('jS M Y, g:i a') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 grow">
                            <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                    </p>
                @endif
            </div>
            <div class="divider divider-vertical"></div>
            <div class="w-full" x-show="selectedWindowTitle == 'showWorkLog'">
                <div class="flex justify-between">
                    <h5 class="text-lg font-bold">{{ $workLog->workScopeTitle() }}</h5>
                    <label for="my_modal_7" class="link link-primary" @click="isEditing = true">Kemaskini</label>
                    {{-- <button class="btn" onclick="my_modal_4.showModal()">open modal</button> --}}
                    <input type="checkbox" id="my_modal_7" class="modal-toggle" />
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
                    </div>
                </div>
                <x-work-logs.status-badge :$workLog />
                <div class="flex justify-between my-5">
                    <span class="text-gray-500">Tarikh cipta</span>
                    <span>{{ $workLog->created_at->format('jS M Y, g:i a') }}</span>
                </div>
                <span class="text-gray-500">Penjelasan</span>
                <p class="my-5">{{ $workLog->description }}</p>
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
            </div>
        </div>{{-- Left Side : Worklog Summary --}}

        <div class="flex flex-col gap-8 basis-7/12"> {{-- Right Side : Submissions --}}
            @foreach ($workLog->submissions as $submission)
                <div class="shadow-xl card @if ($submission->accept) bg-[#E7F7E5] @else bg-white @endif">
                    <div class="card-body">
                        <div class="flex items-center justify-between w-full">
                            <h1 class="text-xl font-bold text-gray-800">Penghantaran No {{ $loop->remaining + 1 }}</h1>
                            @if ($submission->accept)
                                <span class="flex items-center gap-2 font-bold text-green-600">
                                    DITERIMA
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </span>
                            @endif

                        </div>
                        <div class="flex items-end justify-between w-full">
                            <p class="text-green-700">Pada 16 May 2024</p>
                            <p class="text-right text-green-700">Pada 16 May 2024</p>
                        </div>
                        <div class="divider divider-success opacity-10"></div>
                        <h3 class="font-bold text-green-900">Nota</h3>
                        <p class="text-green-800">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque
                            repudiandae voluptas deleniti
                            tenetur eius sit porro nemo, maiores et rem vitae excepturi dicta cupiditate, soluta
                            architecto
                            dolores magnam ea amet aspernatur mollitia voluptatem harum. Modi voluptatum, quia iure
                            quas,
                            accusantium incidunt aspernatur aperiam adipisci saepe quod qui cupiditate recusandae nobis!
                        </p>

                        <div class="divider"></div>
                        <div x-data="{ expanded: false }">
                            <div class="flex items-center justify-between gap-4 mb-3" @click="expanded = ! expanded">
                                <h3 class="text-lg font-bold text-slate-600">
                                    Gambar-gambar
                                    <div class="ml-1 text-white badge badge-neutral">12</div>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="inline w-5 h-5 transition-transform" :class="expanded && 'rotate-180'">
                                        <path fill-rule="evenodd"
                                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </h3>
                                <a class="ml-2 btn btn-outline btn-sm">
                                    Muat Turun Semua
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                            <div class="transition-all masonry-with-columns" :class="expanded && 'mb-8'"
                                x-show="expanded" x-collapse>
                                @for ($i = 0; $i < 8; ++$i)
                                    <div class="p-1 border h-fit rounded-xl bg-slate-100 border-slate-200">
                                        <div class="relative rounded-lg overflow-clip group">
                                            <div
                                                class="absolute z-10 w-full h-full transition-opacity duration-200 ease-in-out bg-black opacity-0 group-hover:opacity-60">
                                            </div>

                                            @if ($i / 2 == 0)
                                                <img src="https://picsum.photos/150/150"
                                                    class="w-full transition-transform duration-200 ease-in-out group-hover:scale-125">
                                            @else
                                                <img src="https://picsum.photos/300/150"
                                                    class="w-full transition-transform duration-200 ease-in-out group-hover:scale-125">
                                            @endif

                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div x-data="{ expanded: false }"> <!-- Dokumen -->

                            <div class="flex items-center justify-between gap-4 mb-3" @click="expanded = ! expanded">
                                <h3 class="text-lg font-bold text-slate-600">
                                    Dokumen-dokumen
                                    <div class="ml-1 text-white badge badge-neutral">12</div>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="inline w-5 h-5 transition-transform" :class="expanded && 'rotate-180'">
                                        <path fill-rule="evenodd"
                                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </h3>
                                <a class="ml-2 btn btn-outline btn-sm">
                                    Muat Turun Semua
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                            <div class="flex flex-wrap w-full gap-4" x-show="expanded" x-collapse>
                                @if ($workLog->submitted_at)
                                @endif
                                @for ($i = 0; $i < 10; ++$i)
                                    <div class="flex items-center gap-1 pl-2 pr-4 border rounded-lg bg-slate-50">
                                        <div class="flex flex-row items-center justify-center gap-4">
                                            <div class="btn btn-circle btn-ghost btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path
                                                        d="M8.75 2.75a.75.75 0 0 0-1.5 0v5.69L5.03 6.22a.75.75 0 0 0-1.06 1.06l3.5 3.5a.75.75 0 0 0 1.06 0l3.5-3.5a.75.75 0 0 0-1.06-1.06L8.75 8.44V2.75Z" />
                                                    <path
                                                        d="M3.5 9.75a.75.75 0 0 0-1.5 0v1.5A2.75 2.75 0 0 0 4.75 14h6.5A2.75 2.75 0 0 0 14 11.25v-1.5a.75.75 0 0 0-1.5 0v1.5c0 .69-.56 1.25-1.25 1.25h-6.5c-.69 0-1.25-.56-1.25-1.25v-1.5Z" />
                                                </svg>

                                            </div>
                                            <div class="-ml-2 rounded badge badge-ghost badge-xs">4.5MB</div>
                                            <span>{{ str(fake()->name . fake()->name . fake()->name)->kebab() . '.pdf' }}</span>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div> <!-- Dokumen -->

                    </div>
                </div>
            @endforeach

            {{-- @if (!auth()->user()->isStaff())
            <div class="flex mt-8" x-show="selectedWindowTitle == 'showWorkLog'">
                <div class="w-52">
                    <h4 class="w-52">Staff</h4>
                </div>
                <div>
                    <a class="link link-primary">{{ $workLog->author->name }}</a>
                    <h5 class="link link-primary">{{ $workLog->author->id }}</h5>
                </div>
            </div>
        @endif --}}

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
                    {{-- Submit --}}
                    <div class="w-full" x-show="selectedWindowTitle == 'submitWorkLog'" x-transition>
                        <div class="flex items-start gap-12">

                            <div id="right-side" class="w-[38rem]">
                                <div class="w-full">
                                    <input name="image-upload" type="file" id="image-upload" />
                                    <input name="document-upload" type="file" id="document-upload" />
                                </div>
                            </div>

                            <div id="left-side" class="shrink w-[18rem]">
                                <h3 class="mb-6 font-bold text-gray-800">Bukti Kerja</h3>

                                {{-- <h3 class="font-extrabold">{{ $workLog->workScope->title }}</h3>
                            <h4 class="text-gray-500">{{ $workLog->started_at->format('jS M Y, g:i a') }}</h4>
                            <p>{{ $workLog->description }}</p> --}}
                                <p class="mb-5 text-gray-600">Tarik fail dari komputer anda dan letak di ruang muat naik
                                    sebelah
                                    ini</p>
                                <p class="mb-5 text-gray-600">Fail yang diterima adalah gambar dan dokumen</p>
                            </div>
                        </div>
                    </div>
                @endunless
            </div>

            {{-- Buttons --}}
            {{-- @if (auth()->user()->isStaff())
            @unless ($workLog->submitted_at && ($workLog->level_1_accepted_at || $workLog->level_2_accepted_at))
                <div class="flex items-center justify-end w-full gap-4 mt-20" x-show="selectedWindowTitle == 'showWorkLog'"
                    x-transition>
                    @unless ($workLog->submitted_at)
                        <button type="button" class="text-white capitalize btn btn-secondary"
                            @click="selectedWindowTitle = 'editWorkLog'">Kemaskini</button>
                    @endunless

                    <button type="button" class="text-white capitalize btn btn-primary"
                        @click="selectedWindowTitle = 'submitWorkLog'">Hantar Kerja</button>
                </div>

                <div class="flex items-center justify-end w-full gap-4 mt-20" x-show="selectedWindowTitle == 'editWorkLog'"
                    x-transition>
                    <form action="">
                        <button type="button" class="text-white capitalize btn btn-primary">Hantar</button>
                    </form>
                    <button type="button" class="capitalize btn btn-ghost"
                        @click="selectedWindowTitle = 'showWorkLog'">Batal</button>
                </div>

                <div class="flex items-center justify-end w-full gap-4 mt-20"
                    x-show="selectedWindowTitle == 'submitWorkLog'" x-transition>
                    <form action="/workLogs/{{ $workLog->id }}/submit" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="button" class="text-white capitalize btn btn-primary">Hantar</button>
                    </form>
                    <button type="button" class="capitalize btn btn-ghost"
                        @click="selectedWindowTitle = 'showWorkLog'">Batal</button>
                </div>
            @endunless
        @else
            @if ($workLog->status == WorkLogHelper::ONGOING)
                @livewire('work-logs.edit.set-status', compact('workLog'))
            @endif
        @endif --}}


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
                const imageUploadElement = document.getElementById('image-upload');
                const documentUploadElement = document.querySelector('#document-upload');

                const workLogId = {{ $workLog->id }};

                // Create a FilePond instance
                const pondImages = FilePond.create(imageUploadElement, {
                    allowMultiple: true,
                    server: {
                        process: {
                            url: `/workLogs/${workLogId}/images`,
                            headers: {
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            },
                        },
                    },
                    labelIdle: 'Tarik & Letak <span class="font-bold">gambar</span> atau <span class="filepond--label-action"> Buka Carian </span>',
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
