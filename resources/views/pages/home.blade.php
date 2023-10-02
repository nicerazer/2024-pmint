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

    <div class="flex items-start w-full gap-8">
        {{-- WorkLogs --}}
        <div class="shadow-xl card min-w-[34rem] bg-base-100">
            <div class="card-body">
                <h2 class="font-normal text-gray-600 card-title">Kerja Berlangsung</h2>

                <div class="flex flex-col">
                    @forelse ($workLogs['ongoing'] as $workLog)
                        {{-- <a --}}
                        <a href="{{ route('workLogs.show', $workLog) }}" wire:link
                            class="flex flex-row items-center justify-between px-2 py-3 -mx-2 transition-colors rounded-lg hover:bg-gray-200">
                            <div>
                                <p class="mb-1 text-lg font-semibold text-gray-600">
                                    {{ $workLog->workScope->title }}</p>
                                <p class="mb-3 text-gray-500">Mula: {{ $workLog->expected_at->format('h:m A') }}</p>
                                <p class="mb-3 text-gray-500">Mula: {{ now() }}</p>
                                <p class="badge badge-error">
                                    {{ now()->diffForHumans($workLog->expected_at) }}</p>
                                {{-- {{ $workLog->time_left }}</p> --}}
                            </div>
                            <span class="text-white btn btn-primary btn-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                        </a>
                        <div class="my-0 divider"></div>
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
        <div class="w-full shadow-xl card bg-base-100">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
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
    </div>

</x-app-layout>
