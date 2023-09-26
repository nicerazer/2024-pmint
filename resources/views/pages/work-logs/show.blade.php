@php
    use App\Helpers\WorkLogHelper;
@endphp
<x-app-layout>


    <div class="max-w-4xl mx-auto mt-16 pb-80"> <!-- main container -->
        <h1 class="text-2xl font-bold">Ringkasan Kerja</h1>
        <h2>No.21414</h2>
        <div class="w-10 h-1 mt-2 rounded-lg bg-primary"></div>

        <div class="flex mt-12">
            <div class="w-52">
                <h4 class="w-52">Staff</h4>
            </div>
            <div>
                <a class="link link-primary">{{ $workLog->author->name }}</a>
                <h5 class="link link-primary">{{ $workLog->author->id }}</h5>
            </div>
        </div>

        <div class="flex mt-8">
            <div class="w-52">
                <h4 class="w-52">Skop Kerja</h4>
            </div>
            <div>
                <h5>{{ $workLog->workscope->title }}</h5>
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
            <div>
                <h5>{{ $workLog->description }}</h5>
            </div>
        </div>

        @if ($workLog->status == workLogHelper::ONGOING)
            @livewire('workLogs.edit.set-status', compact('workLog'))
        @endif

        <!-- Related documents -->
        <div class="mb-12 text-center mt-44">
            <h2 class="mb-4 text-xl">Dokumen yang disertakan</h2>
            <span class="mb-5 badge badge-lg badge-ghost">15 gambar, 12 .docx, 10.xlsx, 3 lain-lain</span>
            <div class="w-10 h-1 mx-auto rounded-lg bg-primary"></div>
        </div>

        <!-- Gambar-gambar -->
        <div class="mb-24">
            <div class="flex items-center gap-6 mb-5">
                <h4 class="text-lg">Gambar-gambar</h4>
                <a href="/" class="flex items-center gap-1 link link-primary">
                    <span>muat turun semua</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <div class="flex gap-4 overflow-x-auto">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
                <img src="ex1.jpg" alt="" class="rounded-lg h-52">
            </div>
        </div>

        <!-- Dokumen-dokumen -->
        <div class="mb-24">
            <div class="flex items-center gap-6 mb-5">
                <h4 class="text-lg">Dokumen-dokumen</h4>
                <a href="/" class="flex items-center gap-1 link link-primary">
                    <span>muat turun semua</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M8 1a.75.75 0 01.75.75V6h-1.5V1.75A.75.75 0 018 1zm-.75 5v3.296l-.943-1.048a.75.75 0 10-1.114 1.004l2.25 2.5a.75.75 0 001.114 0l2.25-2.5a.75.75 0 00-1.114-1.004L8.75 9.296V6h2A2.25 2.25 0 0113 8.25v4.5A2.25 2.25 0 0110.75 15h-5.5A2.25 2.25 0 013 12.75v-4.5A2.25 2.25 0 015.25 6h2zM7 16.75v-.25h3.75a3.75 3.75 0 003.75-3.75V10h.25A2.25 2.25 0 0117 12.25v4.5A2.25 2.25 0 0114.75 19h-5.5A2.25 2.25 0 017 16.75z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <div class="flex flex-wrap w-full gap-4">
                <button class="flex items-center gap-2 btn btn-sm btn-neutral rounded-box">
                    <span>ascnklanlkanscacs.docx</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                </button>
                <button class="flex items-center gap-2 btn btn-sm btn-neutral rounded-box">
                    <span>14145.docx</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                </button>
                <button class="flex items-center gap-2 btn btn-sm btn-neutral rounded-box">
                    <span>ascnklanlkanscacs.docx</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                </button>
                <button class="flex items-center gap-2 btn btn-sm btn-neutral rounded-box">
                    <span>ascnklanlkanscacs.docx</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                </button>
                <button class="flex items-center gap-2 btn btn-sm btn-neutral rounded-box">
                    <span>ascnklanlkanscacs.docx</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                </button>
            </div>

        </div> <!-- Dokumen-dokumen -->

        <!-- Penolakan / Komen -->
        <div class="mb-12 text-center mt-44">
            <h2 class="mb-4 text-2xl">Penolakan & Komen</h2>
            <div class="w-10 h-1 mx-auto rounded-lg bg-primary"></div>
        </div>

        <div class="flex flex-col gap-16 mt-8">
            <div class="flex">
                <div class="w-72">
                    <h4 class="text-lg w-72">Penolakan no.1</h4>
                    <h4 class="w-72 text-slate-500">12.30pm, 12 May 2023</h4>
                </div>
                <div>
                    <h5 class="text-slate-600">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem
                        iste minima dolorum earum temporibus, rem itaque quisquam. Accusamus eveniet praesentium
                        laudantium ipsa? Similique perferendis laudantium numquam autem fugit, quia fugiat! Quod rem ex
                        fuga voluptatibus?</h5>
                </div>
            </div>
            <hr>
            <div class="flex">
                <div class="w-72">
                    <h4 class="text-lg w-72">Penolakan no.1</h4>
                    <h4 class="w-72 text-slate-500">12.30pm, 12 May 2023</h4>
                </div>
                <div>
                    <h5 class="text-slate-600">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem
                        iste minima dolorum earum temporibus, rem itaque quisquam. Accusamus eveniet praesentium
                        laudantium ipsa? Similique perferendis laudantium numquam autem fugit, quia fugiat! Quod rem ex
                        fuga voluptatibus?</h5>
                </div>
            </div>
            <hr>
        </div>

    </div> <!-- main container -->

</x-app-layout>
