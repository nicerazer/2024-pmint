@php
    use App\Helpers\WorkLogHelper;
    use App\Models\WorkScope;
    use Illuminate\Support\Facades\Storage;
@endphp
<x-app-layout>

    <div class="flex w-10/12 mx-auto mt-16 pb-80 " x-data="{ selectedWindowTitle: 'showWorkLog' }"> <!-- main container -->
        {{-- Ringkasan Kerja* Title --}}
        <div class="flex flex-col basis-5/12">
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
            <div class="w-full" x-show="selectedWindowTitle == 'showWorkLog'" x-transition>
                <div class="flex justify-between">
                    <h5 class="text-lg font-bold">{{ $workLog->workScopeTitle() }}</h5>
                    <a href="" class="link link-primary">Kemaskini</a>
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
        </div>

        <div class="flex flex-col basis-7/12">

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
                                        <option value="{{ $workScope->id }}" @if ($workLog->workscope->id == $workScope->id) selected @endif>
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
                                <textarea wire:model="description" placeholder="Keterangan..." class="w-full textarea textarea-bordered" rows="5">{{ $workLog->description }}</textarea>
                            </div>
                        </div>
                    </div>
                @endunless
                {{-- Submit --}}
                <div class="w-full" x-show="selectedWindowTitle == 'submitWorkLog'" x-transition>
                    <div class="flex items-start gap-12">

                        <div id="right-side" class="w-[38rem]">
                            {{-- <div class="divider"></div> --}}
                            <div class="w-full">
                                <input name="image-upload" type="file" id="image-upload" />
                                <input name="document-upload" type="file" id="document-upload" />
                            </div>


                            {{-- <div class="divider"></div> --}}

                            {{--
                            <button type="button"
                                class="group w-full py-12 px-8 btn btn-outline btn-primary hover:!text-white flex flex-col items-center justify-center h-fit capitalize mb-6 bg-white">
                                <div class="flex items-center gap-4">
                                    <span>Tambah Fail</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                    </svg>

                                </div>
                                <div class="bg-primary h-0.5 group-hover:bg-white w-8 transition-colors my-2"></div>
                                <div class="whitespace-break-spaces">Tarik fail ke ruang ini / tekan untuk muat naik</div>
                            </button>
                            --}}

                            {{-- <h3 class="mb-3 text-lg text-gray-600">Dokumen</h3>
                            <div class="flex flex-wrap w-full mb-6 gap-x-2 gap-y-3">
                                @for ($i = 0; $i < 5; $i++)
                                    <div
                                        class="flex items-center gap-2 px-3 py-2 border bg-accent text-accent-content rounded-box">
                                        <span>alksndlaksd.docx</span>
                                        <button type="button" class="opacity-60 hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-5 h-5">
                                                <path
                                                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </button>
                                    </div>
                                @endfor
                            </div>

                            <h3 class="mb-3 text-lg text-gray-600">Gambar</h3>
                            <div class="flex flex-wrap w-full mb-6 gap-x-2 gap-y-3">
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="relative w-fit">
                                        <img src="{{ asset('images/photo-1550258987-190a2d41a8ba.jpg') }}" alt=""
                                            class="h-64 border rounded-box">
                                        <button type="button"
                                            class="absolute z-10 top-3 right-3 opacity-60 hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                @endfor
                            </div> --}}

                        </div>

                        <div id="left-side" class="shrink w-[18rem]">
                            <h3 class="mb-6 font-bold text-gray-800">Bukti Kerja</h3>

                            {{-- <h3 class="font-extrabold">{{ $workLog->workScope->title }}</h3>
                            <h4 class="text-gray-500">{{ $workLog->started_at->format('jS M Y, g:i a') }}</h4>
                            <p>{{ $workLog->description }}</p> --}}
                            <p class="mb-5 text-gray-600">Tarik fail dari komputer anda dan letak di ruang muat naik sebelah
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
