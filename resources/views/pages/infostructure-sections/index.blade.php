<x-app-layout>
    <x-slot:header></x-slot:header>

    <div class="flex flex-col w-5/6 gap-4 mx-auto card">

        <!--div class="shadow stats stats-vertical lg:stats-horizontal">

            <div class="stat">
                <div class="stat-title">Kerja Berlangsung</div>
                <div class="stat-value">31K</div>
                <div class="stat-desc">Jan 1st - Feb 1st</div>
            </div>

            <div class="stat">
                <div class="stat-title">Jumlah Warga Kerja</div>
                <div class="stat-value">4,200</div>
                <div class="stat-desc">↗︎ 400 (22%)</div>
            </div>

            <div class="stat">
                <div class="stat-title">New Registers</div>
                <div class="stat-value">1,200</div>
                <div class="stat-desc">↘︎ 90 (14%)</div>
            </div>

        </div-->

        <h1 class="mb-2 text-xl">Senarai Bahagian</h1>
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center flex-1 max-w-lg gap-4">
                <input type="text" placeholder="Isi carian" class="w-full input input-md input-bordered" />
                <button class="label-text-alt link link-neutral">Clear</span>
            </div>
            <a href="/bahagian/cipta" class="btn btn-primary">Cipta Bahagian</a>
        </div>


        <div class="w-full overflow-x-auto bg-white shadow card">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Jumlah Unit</th>
                        <th>Jumlah Staff</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\StaffSection::all() as $staffSections)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $staffSections->name }}</td>
                            <td>{{ $staffSections->staffUnits()->count() }}</td>
                            <td>{{ $staffSections->memberCount() }}</td>
                            <td>
                                <a class="btn-primary btn btn-ghost" href="/bahagian/{{ $staffSections->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
