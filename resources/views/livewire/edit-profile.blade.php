<div>

    <div class="py-12 mx-auto">
        <div class="mx-auto space-y-6 px-8 w-[50rem]">
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">

                <h2 class="mb-4 text-lg font-medium text-gray-900">
                    Gambar Profil
                </h2>
                <div class="flex gap-8">
                    <div class="flex-1">

                        <div wire:ignore>
                            <x-input.filepond wire:model="newAvatar" allowFileTypeValidation allowFileSizeValidation
                                acceptedFileTypes="['image/jpg', 'image/jpeg', 'image/png']" maxFileSize="100mb" />
                        </div>
                        <form wire:submit="uploadAvatar">
                            <button class="mt-3 w-52 btn btn-neutral btn-sm">SIMPAN <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path
                                        d="M9.25 13.25a.75.75 0 0 0 1.5 0V4.636l2.955 3.129a.75.75 0 0 0 1.09-1.03l-4.25-4.5a.75.75 0 0 0-1.09 0l-4.25 4.5a.75.75 0 1 0 1.09 1.03L9.25 4.636v8.614Z" />
                                    <path
                                        d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                </svg>
                            </button>
                        </form>
                        {{-- <div wire:loading wire:target="newAvatar">Sedang diuploa</div> --}}
                    </div>
                    <div class="w-52">
                        @if ($newAvatar)
                            <img class="overflow-hidden bg-white border-2 rounded-full w-52 h-52"
                                src="{{ $newAvatar->temporaryUrl() }}" alt="Profile Photo">
                            {{-- <img class="border w-52" src="{{ asset('assets/images/logo.png') }}" alt="Profile Photo"> --}}
                        @elseif (auth()->user()->getMedia('avatar')->count())
                            <img class="object-contain overflow-hidden bg-white border-2 rounded-full size-52"
                                src="{{ auth()->user()->getFirstMediaUrl('avatar') }}" alt="Profile Photo">
                        @else
                            <div
                                class="flex items-center justify-center text-center border-2 rounded-full bg-slate-300 w-52 h-52 ">
                                Tiada Gambar</div>
                        @endif
                    </div>
                </div>

                {{-- <div class="max-w-xl">
                    @include('pages.profile.partials.update-profile-information-form')
                </div> --}}
                {{-- </div> --}}


            </div>

            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <h2 class="mb-6 text-lg font-medium text-gray-900">
                    Maklumat Diri
                </h2>
                <div class="flex flex-col gap-4">
                    <div class="flex">
                        <h3 class="font-medium text-gray-500 w-44">Nama Penuh</h3>
                        <p class="text-black">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="flex">
                        <h3 class="font-medium text-gray-500 w-44">E-Mel</h3>
                        <p class="text-black">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="flex">
                        <h3 class="font-medium text-gray-500 w-44">No Kad Pengenalan</h3>
                        <p class="text-black">{{ auth()->user()->ic }}</p>
                    </div>
                    <div class="flex">
                        <h3 class="font-medium text-gray-500 w-44">Unit</h3>
                        <p class="text-black">{{ auth()->user()->unit->name }}</p>
                    </div>
                    <div class="flex">
                        <h3 class="font-medium text-gray-500 w-44">Bahagian</h3>
                        <p class="text-black">{{ auth()->user()->unit->section->name }}</p>
                    </div>
                    <div class="flex">
                        <h3 class="font-medium text-gray-500 w-44">Jawatan</h3>
                        @if (auth()->user()->position)
                            <p class="text-black">{{ auth()->user()->position }}</p>
                        @else
                            <p class="italic">Tiada tetapan</p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="">
                    @include('pages.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
