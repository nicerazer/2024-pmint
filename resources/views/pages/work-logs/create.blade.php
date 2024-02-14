<x-app-layout>
    <div class="w-4/5 mx-auto mt-2 pb-80"> <!-- main container -->
        <div class="flex items-end justify-between mb-5">
            <h1 class="text-xl font-bold">Daftar Aktiviti</h1>
            <div class="flex gap-8">
                <div>
                    <h2 class="">Penilai 1</h2>
                    <a href="" class="text-xl link link-primary link-hover">Ahmad Najmi bin Ayub</a>
                </div>
                <div>
                    <h2 class="">Penilai 2</h2>
                    <a href="" class="text-xl link link-primary link-hover">Ahmad Najmi bin Ayub</a>
                </div>
            </div>
        </div>

        <div class="divider my-0.5"></div>

        @livewire('work-logs.create-worklog')
    </div>


</x-app-layout>
