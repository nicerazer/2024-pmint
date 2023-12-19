@php
    use App\Helpers\WorkLogHelper;
    use App\Models\WorkScope;
    use Illuminate\Support\Facades\Storage;

    $workLogAccepted = true;
@endphp
<x-app-layout>

    <div class="flex w-10/12 gap-8 mx-auto mt-16 pb-80" x-data="{ selectedWindowTitle: 'showWorkLog', isEditing: false }"> <!-- main container -->

        <div class="flex flex-col basis-5/12"> {{-- Left Side : Worklog Summary --}}
            <div class="flex items-start justify-between">
                <div>
                    {{-- Worklog Title --}}
                    <h1 class="text-2xl font-bold" x-show="selectedWindowTitle == 'showWorkLog'">Ringkasan Kerja</h1>
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
                    <span class="text-gray-500">Waktu mula</span>
                    <span>{{ $workLog->created_at->format('jS M Y, g:i a') }}</span>
                </div>
                <div class="flex justify-between my-5">
                    <span class="text-gray-500">Waktu tamat</span>
                    <span>{{ $workLog->created_at->format('jS M Y, g:i a') }}</span>
                </div>
                <div class="divider divider-vertical"></div>
            </div>
        </div>{{-- Left Side : Worklog Summary --}}

        <div class="flex flex-col basis-7/12"> {{-- Right Side : Submissions --}}
            <div class="card @if ($workLogAccepted) bg-green-100 @else bg-white @endif">
                <div class="card-body">
                    <div class="flex items-center justify-between w-full">
                        <h1 class="text-2xl font-bold">Penghantaran No-1</h1>
                        @if ($workLogAccepted)
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
                    <p class="mb-4 text-gray-500">16 May 2024</p>
                    <p class="text-gray-600">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque
                        repudiandae voluptas deleniti
                        tenetur eius sit porro nemo, maiores et rem vitae excepturi dicta cupiditate, soluta architecto
                        dolores magnam ea amet aspernatur mollitia voluptatem harum. Modi voluptatum, quia iure quas,
                        accusantium incidunt aspernatur aperiam adipisci saepe quod qui cupiditate recusandae nobis!</p>

                    <div class="divider"></div>
                    <div class="mb-5">
                        <h3 class="mb-3">Gambar-gambar
                            <a class="ml-2 btn btn-secondary btn-xs">
                                Muat Turun Semua
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </h3>
                        <div class="flex flex-wrap w-full gap-4">
                            @for ($i = 0; $i < 4; ++$i)
                                <img src="https://picsum.photos/150/150" class="rounded">
                            @endfor
                        </div>
                    </div>
                    <h3 class="mb-3">Dokumen-dokumen
                        <a class="ml-2 btn btn-secondary btn-xs">
                            Muat Turun Semua
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </h3>
                    <div class="flex flex-wrap w-full gap-4">
                        @if ($workLog->submitted_at)
                        @endif
                        @for ($i = 0; $i < 10; ++$i)
                            {{-- <livewire:worklogs-show- /> --}}
                            {{-- <div class="flex items-center gap-1 p-2 bg-white border rounded-lg"> --}}
                            <div class="flex items-center gap-1 p-2 bg-white border rounded-lg">
                                <div class="flex flex-col items-start justify-center gap-2">
                                    Evidence {{ $i }}
                                    <div class="flex gap-2">
                                        {{-- <div class="rounded badge badge-neutral badge-sm">XLSX</div>
                                        <div class="rounded badge badge-neutral badge-sm">4.5MB</div> --}}
                                        <div class="rounded badge badge-ghost badge-sm">XLSX</div>
                                        <div class="rounded badge badge-ghost badge-sm">4.5MB</div>
                                        {{-- <div class="rounded badge badge-neutral badge-sm">No-Lock</div </div> --}}
                                    </div>
                                </div>
                                <div class="dropdown dropdown-bottom dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" class="w-5 h-5">
                                            <path
                                                d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                        </svg>
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li>
                                            <a>
                                                <span>Muat Turun</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 ml-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <span>Buang</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 ml-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        @endfor
                    </div>
                </div>
            </div>

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
