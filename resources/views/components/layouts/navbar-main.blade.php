<nav class="px-16 py-5 navbar bg-primary">
    <div class="navbar-start">
        <a href="/" wire:navigate class="text-lg text-white normal-case btn btn-ghost">PMINT - Sistem Log
            Aktiviti</a>
        <div class="ml-12 text-white">
            @if (auth()->user()->isAdmin())
                <a href="/" wire:navigate class="text-white capitalize btn btn-ghost">Ruang Kemaskini</a>
                <a href="/data-report" wire:navigate class="text-white capitalize btn btn-ghost">Laporan</a>
            @else
                <a href="/" wire:navigate class="text-white capitalize btn btn-ghost">Senarai Log Kerja</a>
            @endif
            {{-- <a href="/staff-units" wire:navigate class="text-white capitalize btn btn-ghost">Unit</a> --}}
            {{-- @endif --}}
        </div>
    </div>
    {{-- <div class="navbar-center">
        <div class="form-control">
            <input type="text" placeholder="Search" class="text-black input input-bordered w-80 input-md" />
        </div>
    </div> --}}
    <div class="navbar-end">

        <div class="mr-8 dropdown dropdown-end">
            <div tabindex="0" role="button" class="text-white capitalize btn btn-ghost rounded-btn">Mod
                <span class="badge-secondary badge">
                    {{ App\Models\Role::find(session('selected_role_id'))->title }}
                </span>
            </div>
            <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                @foreach (auth()->user()->roles->sortBy('id') as $role)
                    <li>
                        <form action="{{ route('switch-role', $role->id) }}" method="POST" class="flex p-0">
                            @csrf @method('PUT')
                            <button class="w-full btn btn-ghost text-start">{{ ucfirst($role->title) }}</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    @php
                        $notifCounts = auth()->user()->unreadNotifications()->count();
                    @endphp
                    @if ($notifCounts)
                        <span class="badge badge-sm indicator-item">{{ $notifCounts }}</span>
                    @endif
                </div>
            </div>
            <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-[24rem] bg-base-100 shadow">
                <div class="card-body">
                    <div class="flex justify-between pb-1 border-b">
                        <h4 class="font-semibold text-gray-600 hover:text-gray-700">
                            <span>Notifikasi</span>

                        </h4>
                        <button class="link link-secondary link-hover">Set baca semua</button>
                    </div>
                    <div class="flex flex-col gap-2 border-b">
                        @foreach (auth()->user()->unreadNotifications()->limit(5)->get() as $notif)
                            <x-notifications.item :notif="$notif" wire:key="{{ $notif->id }}" />
                        @endforeach
                    </div>
                    <div class="flex flex-row items-center justify-between w-full">
                        <span>{{ $notifCounts }} belum dibaca</span>
                        <button class="link link-hover link-neutral" onclick="notifModal.showModal()">
                            Buka lagi
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-1 mb-0.5 inline size-5">
                                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
                              </svg>
                        </button>
                    </div>
                    {{-- <span class="text-lg font-bold">8 Items</span>
                    <span class="text-info">Subtotal: $999</span>
                    <div class="card-actions">
                    <button class="btn btn-primary btn-block">View cart</button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="ml-12 dropdown dropdown-end">
            <label tabindex="0" class="flex gap-4 text-white capitalize btn btn-ghost">
                {{ auth()->user()->name }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                </svg>
            </label>
            <div tabindex="0" class="dropdown-content z-[1] card card-compact w-96 p-2 bg-white shadow">
                <div class="card-body">
                    <div class="flex gap-4 mb-3">
                        @if (auth()->user()->getMedia('avatar')->count())
                            <img src="{{ auth()->user()->getFirstMediaUrl('avatar') }}" alt="Avatar"
                                class="object-contain mx-auto bg-white border rounded-full size-16">
                        @else
                            <div class="w-16 h-16 bg-gray-400 rounded-full"></div>
                        @endif
                        <div class="flex-grow">
                            <h4 class="mb-0 capitalize card-title">{{ auth()->user()->name }}</h4>
                            <div class="flex justify-between gap-3">
                                <h5 class="text-sm text-gray-500">{{ auth()->user()->email }}</h5>
                                <h5 class="mb-2"><span class="font-bold"></span>ID<span class="ml-1 badge badge-ghost">{{ auth()->user()->id }}</span></h5>
                            </div>
                            {{-- <div class="w-4 h-0.5 rounded-full bg-accent"></div> --}}
                        </div>

                    </div>
                    <ul class="p-0 menu">
                        <li><a href="/profile">Profil</a></li>
                        <li>
                            <a href="{{ route('logout') }}" class="btn-error btn btn-sm !text-start mt-2">Log Keluar</a>
                            {{-- <button>asdasd</button> --}}
                            {{-- <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="text-error hover:bg-error hover:text-red-900">Log Keluar</button>
                            </form> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <livewire:notifications.modal />
</nav>
