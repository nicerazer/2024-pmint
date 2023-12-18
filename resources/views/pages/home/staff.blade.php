<x-app-layout>

    <x-slot:header>
        <div class="justify-center py-16 bg-slate-700">
            <div class="w-9/12 mx-auto text-white">
                <h1 class="flex mb-1 text-3xl capitalize">{{ auth()->user()->name }}
                    <span class="flex items-center ml-4 font-bold text-primary">
                        <span>4.5</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="inline w-6 h-6 ml-2">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                clip-rule="evenodd" />
                        </svg>

                    </span>
                </h1>
                <h2 class="text-xl capitalize">{{ auth()->user()->unit ?? 'unassigned' }}</h2>
            </div>
        </div>
    </x-slot:header>
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

        <section class="flex flex-col gap-8 grow"> <!-- Summary Section -->
            {{-- WorkLogs --}}
            <div class="bg-white border card grow">
                <div class="py-4 card-body">
                    <div class="flex justify-between">
                        <h2 class="font-light text-gray-400 card-title">Kerja Berlangsung</h2>
                        <div class="flex items-center">
                            <button class="align-middle btn btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Cipta Log
                            </button>
                            <button class="align-middle btn btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                Senarai Log
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        @forelse ($workLogs['ongoing'] as $workLog)
                            <div class="flex items-start gap-4 py-2">
                                <a href="" class="text-gray-400 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                </a>
                                <div class="grow">
                                    <a href="{{ route('workLogs.show', $workLog) }}" wire:link
                                        class="flex flex-row items-center justify-between px-2 py-2 -mx-2 -my-2 transition-colors rounded-lg hover:bg-gray-100 grow">
                                        <div class="grow">
                                            <div class="flex items-center justify-start gap-4 mb-2">
                                                <div class="text-lg font-semibold text-gray-600 w-fit">
                                                    {{ $workLog->workScope->title }}</div>
                                                @php
                                                    $revisionCount = $workLog->revisions()->count();
                                                @endphp
                                                <div
                                                    class="badge font-bold uppercase badge-{{ $revisionCount != 0 ? 'secondary' : 'info text-white' }}">
                                                    {{ $revisionCount != 0 ? 'Ulangan Ke-' . $revisionCount : 'Tiada Ulangan' }}
                                                </div>
                                            </div>
                                            {{-- WorkLog Date Stats --}}
                                            <div class="overflow-visible bg-transparent stats">
                                                <div class="py-0 pl-0 stat">
                                                    <div class="stat-title">Mula Pada</div>
                                                    @php
                                                        $diffInDays = $workLog->started_at->diffInDays();
                                                        $diffSentence = '';
                                                        if ($diffInDays == 0) {
                                                            $diffSentence = 'Hari Ini';
                                                        } else {
                                                            $diffSentence = $diffInDays . ' Hari Lalu';
                                                        }
                                                    @endphp
                                                    <div class="text-2xl stat-value text-primary">Hari Ini</div>
                                                    <div class="stat-desc">{{ $workLog->started_at->format('jS F') }}
                                                    </div>
                                                </div>
                                                <div class="py-0 stat">
                                                    <div class="stat-title">Jangka Siap</div>
                                                    @php
                                                        $diffInDays = $workLog->expected_at->diffInDays();
                                                        $diffSentence = '';
                                                        if ($diffInDays == 0) {
                                                            $diffSentence = 'Hari Ini';
                                                        } else {
                                                            $diffSentence = $diffInDays . ' Hari Lagi';
                                                        }
                                                    @endphp
                                                    <div class="text-2xl stat-value text-primary">{{ $diffSentence }}
                                                    </div>
                                                    <div class="stat-desc">{{ $workLog->expected_at->format('jS F') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d=" M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="mb-0 divider"></div>

                                </div>
                            </div>
                            {{-- <div class="my-0 divider"></div> --}}
                        @empty
                            <div class="w-full my-32 text-center">Empty</div>
                        @endforelse
                    </div>

                    <div class="justify-center card-actions">
                        <button class="capitalize link link-primary">Lihat lagi</button>
                    </div>
                </div>
            </div>

            {{-- Comments --}}
            <div class="w-full border card bg-base-100 grow">
                <div class="card-body">
                    <h2 class="font-normal text-gray-600 card-title">
                        <span>Komen Terbaru</span>
                        <span class="ml-2 badge badge-lg badge-ghost">12</span>
                    </h2>

                    <div class="flex flex-col">
                        @forelse ($workLogs['with_comments'] as $workLog)
                            <a href="/" class="px-2 py-3 -mx-2 transition-colors rounded-lg hover:bg-gray-200">
                                <div class="flex">
                                    <div>
                                        <p class="mb-1 text-lg font-semibold text-gray-600">Letak jawatan warga kerja
                                        </p>
                                        <p class="mb-4 text-gray-500">
                                            {{ str()->of($workLog->description)->limit(200) }}
                                        </p>
                                    </div>

                                    <span class="ml-5 text-sm text-gray-400 whitespace-nowrap">3 hari lepas</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex gap-3">
                                        <span class="badge badge-secondary badge-lg">REJECT</span>
                                        <span class="badge badge-ghost badge-lg">HARIAN</span>
                                    </div>
                                    <div class="flex flex-col justify-between h-full ml-3">
                                        <span
                                            class="flex flex-col items-center gap-3 pr-6 btn btn-primary btn-sm btn-ghost">
                                            Buka
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd"
                                                    d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </span>
                                    </div>
                                </div>
                            </a>
                            <div class="-mx-8 divider"></div>
                        @empty
                            <div class="w-full my-32 text-center">Empty</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section> <!-- Summary Section -->
    </div>

</x-app-layout>
