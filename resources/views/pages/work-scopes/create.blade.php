<x-app-layout>
    <x-slot:header>

    </x-slot:header>

    <div class="flex flex-col items-start w-5/6 gap-4 mx-auto" x-data="{ tabSelectIsStaff: false }">
        <div class="flex justify-between w-full">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="/">Bahagian</a></li>
                    <li>{{ $staffSection->name }}</li>
                    <li><a href="/bahagian/{{ $staffSection->id }}">Unit</a></li>
                    <li>{{ $staffUnit->name }}</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
