<x-app-layout>

    <div class="flex gap-14 grow">
        <section class="min-w-[20rem]"><!-- Profile Section -->
            <img src="{{ asset('storage/placeholder-avatars/funEmoji-1702910749853.jpg') }}" alt="Avatar"
                class="w-full mb-8 border rounded-xl">
            <div class="mb-4">
                <h2 class="text-xl font-bold capitalize">{{ auth()->user()->name }}</h2>
                <p class="text-xl text-gray-600 capitalize">{{ 'Pengurus Besar Khidmat Sokongan' }}</p>
            </div>
            <a href="" class="w-full btn btn-neutral">Kemaskini Profil</a>
            <div class="divider"></div>
            <div class="w-full bg-white border stats stats-vertical">

                <div class="stat">
                    <div class="stat-title">Log Kerja</div>
                    <div class="stat-value">31K</div>
                    <div class="stat-desc">Disember 2023</div>
                </div>

                <div class="stat">
                    <div class="stat-title">New Users</div>
                    <div class="stat-value">4,200</div>
                    <div class="stat-desc">↗︎ 400 (22%)</div>
                </div>

                <div class="stat">
                    <div class="stat-title">New Registers</div>
                    <div class="stat-value">1,200</div>
                    <div class="stat-desc">↘︎ 90 (14%)</div>
                </div>

            </div>
        </section><!-- Profile Section -->

        <div class="grow">
            <section class="flex flex-col gap-8 mb-8 grow"> <!-- Summary Section -->
                <div class="flex items-end justify-between">
                    <div>
                        <h2 class="-mx-4 text-3xl btn btn-ghost">
                            Tahun 2023
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </h2>
                        {{-- <p class="text-gray-600">12 Nov, 2023</p> --}}
                    </div>
                    <div class="text-right">
                        <p class="text-xl text-gray-600">Laporan Log Kerja Staff</p>
                        <h2 class="-mx-4 text-xl font-bold btn btn-ghost">Bahagian Pentadbiran & Sumber Manusia</h2>
                    </div>
                </div>
                {{-- WorkLogs --}}
                <div class="flex justify-between">
                    <input type="text" placeholder="Type here" class="w-full max-w-xs input input-bordered" />
                    <div class="flex items-center gap-4">
                        <button class="btn btn-neutral">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Jana Laporan
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto bg-white"> <!-- Summary log kerja untuk bahagian -->
                    <table class="table table-zebra">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox" />
                                    </label>
                                </th>
                                <th>Bulan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Muat Turun</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- row 1 -->
                            @for ($i = 0; $i < 12; ++$i)
                                <tr>
                                    <th>
                                        <label>
                                            <input type="checkbox" class="checkbox" />
                                        </label>
                                    </th>
                                    <td>
                                        September
                                    </td>
                                    <td>
                                        5
                                    </td>
                                    <td>6</td>
                                    <td>7</td>
                                    <th>
                                        <button class="btn btn-ghost btn-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                                            </svg>
                                        </button>
                                    </th>
                                </tr>
                            @endfor
                        </tbody>
                        <!-- foot -->
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Job</th>
                                <th>Favorite Color</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div> <!-- Summary log kerja untuk bahagian -->
            </section> <!-- Summary Section -->
            <section> <!-- Menu Section -->
                <h2 class="-mx-4 text-3xl btn btn-ghost">
                    September 2023
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </h2>
                <div class="grid grid-cols-4 gap-4">
                    <div></div>
                </div>
            </section> <!-- Menu Section -->
        </div>
    </div>

</x-app-layout>
