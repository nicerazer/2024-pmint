<x-app-layout>
    <x-slot:header></x-slot:header>

    <div class="flex flex-col w-full gap-4">

        <div class="flex gap-4">
            <input type="text" placeholder="" class="w-full max-w-xs input input-bordered" />
            <a href="/bahagian/cipta">Tambah Bahagian</a>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\StaffSection::all() as $staffSections)
                        <tr>
                            <th>{{ $staffSections->name }}</th>
                            <td>
                                <a class="btn-primary btn" href="/staff-sections/{{ $staffSections->id }}">Buka</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
