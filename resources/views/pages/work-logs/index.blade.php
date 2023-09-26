<x-app-layout>
    <div class="w-full">
        <h1 class="mb-6 text-xl">Paparan Kerja</h1>
        <div class="flex items-center gap-4 mb-4">
            <div class="dropdown dropdown-bottom">
                <label tabindex="0" class="font-normal capitalize bg-white border border-gray-200 btn btn-sm">
                    <span>Oktober, 2023</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </label>
                <div tabindex="0"
                    class="dropdown-content z-[1] card card-compact w-64 p-2 shadow bg-primary text-primary-content">
                    <div class="card-body">
                        <h3 class="card-title">Card title!</h3>
                        <p>you can use any element as a dropdown.</p>
                    </div>
                </div>

            </div>
            <input type="text" placeholder="Type here" class="w-full max-w-xs input input-bordered" />

        </div>

        @livewire('work-logs-table')

    </div>
</x-app-layout>
