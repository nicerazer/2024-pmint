<nav class="px-8 py-5 navbar bg-primary">
    <div class="navbar-start">
        <a class="text-xl text-white normal-case btn btn-ghost">Log Kerja</a>
        <div class="ml-12 text-white">
            <a href="/" wire:navigate class="text-white capitalize btn btn-ghost">Utama</a>
            <a href="/logkerja" wire:navigate class="text-white capitalize btn btn-ghost">Kerja</a>
        </div>
    </div>
    <div class="navbar-center">
        <div class="form-control">
            <input type="text" placeholder="Search" class="text-black input input-bordered w-80" />
        </div>
    </div>
    <div class="navbar-end">
        <button class="text-white btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
        </button>
        <button class="text-white btn btn-ghost btn-circle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
            </svg>
        </button>
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
                        <div class="w-16 h-16 bg-gray-400 rounded-full"></div>
                        <div class="flex-grow">
                            <h4 class="mb-0 capitalize card-title">{{ auth()->user()->name }}</h4>
                            <h5 class="mb-2">id: {{ auth()->user()->id }}</h5>
                            <div class="w-8 h-1 rounded-full bg-accent"></div>
                        </div>

                    </div>
                    <ul class="p-0 menu">
                        <li><a href="/profile">Profil</a></li>
                        <li><a href="/messages">Mesej</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="text-error hover:bg-error hover:text-red-900">Log Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
