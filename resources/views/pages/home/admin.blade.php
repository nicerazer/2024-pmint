<x-app-layout>
    <x-slot:header></x-slot:header>

    <div>
        <div class="flex flex-col gap-4"><!-- Left Side (Profile) -->
            <img src="" alt="">
            <div>
                <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                <p class="text-gray-600">{{ 'Pengurus Besar Khidmat Sokongan' }}</p>
            </div>
            <a href="" class="btn btn-neutral">Kemaskini Profil</a>
            <p>15 Log kerja disimpan</p>
        </div><!-- Left Side (Profile) -->
        <div><!-- Right Side (Data & Menus) -->
            <h1 class="text-xl font-bold">Menu Admin</h1>
            <p class="text-gray-600">Laporan Log Kerja</p>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Muat Turun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>November 2023</th>
                        <td>410</td>
                        <td>
                            <div class="badge badge-success">Lengkap</div>
                        </td>
                        <td><a href="/" target="_blank" rel="noopener noreferrer" class="btn btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a></td>
                    </tr>
                </tbody>
            </table>
        </div><!-- Right Side (Data & Menus) -->
    </div>
</x-app-layout>
