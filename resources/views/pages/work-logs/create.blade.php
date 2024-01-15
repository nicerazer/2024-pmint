<x-app-layout>
    <div class="w-4/5 mx-auto mt-4 pb-80"> <!-- main container -->
        <div class="flex items-end justify-between mb-5">
            <h1 class="text-4xl font-bold">Daftar Aktiviti</h1>
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

        <div class="divider"></div>

        @livewire('work-logs.create-worklog')
    </div>


</x-app-layout>
