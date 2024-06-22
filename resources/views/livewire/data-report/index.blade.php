<!-- TODO: Continue working this -->

<div>
    <div class="flex gap-4"
        x-data="{
            staff_section_id: 1,
            staff_unit_id: -1,
            staff_id: -1,
            activity_id: -1,
            model_context: '{{ $model_context }}',
            model_id: {{ $model_id }},
            staff_sections: {{ Illuminate\Support\Js::from($staff_sections) }}
        }"
    >
        <div class="flex flex-col items-end gap-2 w-[28rem]">
            <h2 class="text-2xl font-bold">Laman Laporan Sistem</h2>
            <livewire:work-logs.filters.month :$selected_month />

            <button class="btn btn-sm btn-block btn-primary"
                @click="
                    model_context = 'monthly_overall';
                    $wire.set('model_context', 'monthly_overall');
                    $wire.call('updateChart');
                ">
                Klik disini untuk laporan tahunan
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                </svg>
            </button>

            <livewire:navigation.report-treeview :staff_sections="$staff_sections" />
        </div>

        {{-- Edit windows --}}
        {{-- <div x-show="model_context == 'workscope'" x-cloak class="w-full bg-white border card h-fit">
            <livewire:admin.edit-workscope :$model_id />
        </div> --}}
        <div x-show="model_context == 'staff'" x-cloak class="w-full px-4 py-3 bg-white border card h-fit">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg"><span class="font-bold">Laporan staf</span> @if ($selected_staff)<button wire:click="navigateToEdit"
                         class="link link-hover">{{$selected_staff->name}}</button>@endif</h3>
                    <div class="flex flex-row gap-3">
                        @if ($selected_staff)
                        <h4><div class="mr-1 badge badge-sm badge-ghost">IC</div> {{$selected_staff->ic}}</h4>
                        <h4><div class="mr-1 badge badge-sm badge-ghost">ID</div> {{$selected_staff->id}}</h4>
                        <h4><div class="mr-1 badge badge-sm badge-ghost">Email</div> {{$selected_staff->email}}</h4>
                        @endif
                        @unless ($selected_staff)
                            <h4>Sila pilih staff</h4>
                        @endunless
                    </div>
                </div>
                <div>
                    <button
                        wire:click='download'
                        type="button" class="flex flex-row items-center justify-center w-56 gap-2 align-middle btn-sm btn btn-secondary"><div>Excel: Muat Turun</div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path d="M8 1a.75.75 0 0 1 .75.75V5h-1.5V1.75A.75.75 0 0 1 8 1ZM7.25 5v4.44L6.03 8.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l2.5-2.5a.75.75 0 1 0-1.06-1.06L8.75 9.44V5H11a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2.25Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-full" wire:ignore><canvas id="monthly_staff"></canvas></div>
        </div>
        <div x-show="model_context == 'staff_unit'" x-cloak class="w-full px-4 py-3 bg-white border card h-fit">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">Laporan Unit</h3>
                    @if ($selected_unit)
                        <h4 class="mb-2 text-xl">Unit {{$selected_unit->name}}</h4>
                        {{-- <h4><div class="badge badge-neutral">IC</div> {{$selected_unit->ic}}</h4>
                        <h4><div class="badge badge-neutral">ID</div> {{$selected_unit->id}}</h4> --}}
                        {{-- <h4>Bahagian {{$selected_unit->staff_section}}</h4> --}}
                    @else
                        <h4>Sila pilih unit</h4>
                    @endif
                </div>
                <div>
                    <button
                        wire:click='download'
                        type="button" class="flex flex-row items-center justify-center w-56 gap-2 align-middle btn-sm btn btn-secondary"><div>Excel: Muat Turun</div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path d="M8 1a.75.75 0 0 1 .75.75V5h-1.5V1.75A.75.75 0 0 1 8 1ZM7.25 5v4.44L6.03 8.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l2.5-2.5a.75.75 0 1 0-1.06-1.06L8.75 9.44V5H11a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2.25Z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="w-full" wire:ignore><canvas id="monthly_unit"></canvas></div>
        </div>
        <div x-show="model_context == 'staff_section'" x-cloak class="w-full px-4 py-3 bg-white border card h-fit">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">Laporan Bahagian</h3>
                    @if ($selected_section)
                        <h4 class="mb-2 text-xl">Bahagian {{$selected_section->name}}</h4>
                        {{-- <h4><div class="badge badge-neutral">IC</div> {{$selected_unit->ic}}</h4>
                        <h4><div class="badge badge-neutral">ID</div> {{$selected_unit->id}}</h4> --}}
                        {{-- <h4>Bahagian {{$selected_unit->staff_section}}</h4> --}}
                    @else
                        <h4>Sila pilih bahagian</h4>
                    @endif
                </div>
                <div>
                    <button
                        wire:click='download'
                        type="button" class="flex flex-row items-center justify-center w-56 gap-2 align-middle btn-sm btn btn-secondary"><div>Excel: Muat Turun</div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path d="M8 1a.75.75 0 0 1 .75.75V5h-1.5V1.75A.75.75 0 0 1 8 1ZM7.25 5v4.44L6.03 8.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l2.5-2.5a.75.75 0 1 0-1.06-1.06L8.75 9.44V5H11a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2.25Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full" wire:ignore><canvas id="monthly_section"></canvas></div>
        </div>
        <div x-show="model_context == 'monthly_overall'" x-cloak class="w-full px-4 py-3 bg-white border card h-fit">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-bold">Laporan Keseluruhan</h3>
                </div>
                <div>
                    <button
                        wire:click='download'
                        type="button" class="flex flex-row items-center justify-center w-56 gap-2 align-middle btn-sm btn btn-secondary"><div>Excel: Muat Turun</div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path d="M8 1a.75.75 0 0 1 .75.75V5h-1.5V1.75A.75.75 0 0 1 8 1ZM7.25 5v4.44L6.03 8.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l2.5-2.5a.75.75 0 1 0-1.06-1.06L8.75 9.44V5H11a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2.25Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full" wire:ignore><canvas id="monthly_overall"></canvas></div>
        </div>

    </div>

    {{-- <div style="width: 800px;"><canvas id="monthly_overall"></canvas></div> --}}
    {{-- <div style="width: 800px;"><canvas id="annual_section"></canvas></div> --}}
    {{-- @dump($data) --}}

    {{-- <livewire:test.example> --}}

    <script type="module">
        (async function() {
            let monthly_staff = {{ Js::from($monthly_staff) }};

            let monthly_unit = {{ Js::from($monthly_unit) }};
            let monthly_unit_datasets = [];

            let monthly_section = {{ Js::from($monthly_section) }};
            let monthly_section_datasets = [];

            let monthly_overall = {{ Js::from($monthly_overall) }};
            let monthly_overall_datasets = [];

            Livewire.on('update-chart-staff', (data) => {
                console.log('Updating chart for staff');
                console.log(data[0]);
                chart_staff.data.datasets[0].data = data[0];
                chart_staff.update();
            });

            Livewire.on('update-chart-staff_unit', (data) => {
                console.log('Updating chart for staff unit');
                console.log(data[0]);
                // chart_unit.data.labels = data[0].labels;
                // chart_unit.data.datasets[0].data = data[0].data;
                let temp = [];
                data[0].labels.forEach(label => {
                    temp.push({
                        label: label,
                        data: data[0].data,
                        parsing: {
                            yAxisKey: label
                        }
                    });
                });
                // chart_unit.data.datasets = temp;
                // chart_unit.data.datasets = [{
                //     data: [20, 10],
                // }],
                // chart_unit.data.labels = [{
                //     labels: ['a', 'b']
                // }]
                chart_unit.update();
            });

            Livewire.on('update-chart-staff_section', (data) => {
                console.log('Updating chart for staff section');
                let temp = [];
                data[0].labels.forEach(label => {
                    temp.push({
                        label: label,
                        data: data[0].data,
                        parsing: {
                            yAxisKey: label
                        }
                    });
                });
                chart_section.data.datasets = temp;
                chart_section.update();
            });

            Livewire.on('update-chart-monthly_overall', (data) => {
                console.log('Updating chart for overall');
                let temp = [];
                data[0].labels.forEach(label => {
                    temp.push({
                        label: label,
                        data: data[0].data,
                        parsing: {
                            yAxisKey: label
                        }
                    });
                });
                chart_monthly_overall.data.datasets = temp;
                chart_monthly_overall.update();
            });

            // Chart monthly staff
            const chart_staff = new Chart(
                document.getElementById('monthly_staff'), {
                    type: 'bar',
                    data: {
                        labels: monthly_staff.data.map(row => row.month),
                        datasets: [
                            {
                                label: 'Laporan log aktiviti staff mengikut bulan',
                                data: monthly_staff.data.map(row => row.count)
                            }
                        ]
                    },
                }
            );

            // Chart monthly unit
            monthly_unit.labels.forEach(label => {
                monthly_unit_datasets.push({
                    label: label,
                    data: monthly_unit.data,
                    parsing: {
                        yAxisKey: label
                    }
                });
            });

            const chart_unit = new Chart(
                document.getElementById('monthly_unit'), {
                    type: 'bar',
                    data: { datasets: monthly_unit_datasets },
                }
            );

            // Chart monthly section
            monthly_section.labels.forEach(label => {
                monthly_section_datasets.push({
                    label: label,
                    data: monthly_section.data,
                    parsing: {
                        yAxisKey: label
                    }
                });
            });

            const chart_section = new Chart(
                document.getElementById('monthly_section'), {
                    type: 'bar',
                    data: { datasets: monthly_section_datasets },
                }
            );

            // Chart monthly overall
            monthly_overall.labels.forEach(label => {
                monthly_overall_datasets.push({
                    label: label,
                    data: monthly_overall.data,
                    parsing: {
                        yAxisKey: label
                    }
                });
            });

            const chart_monthly_overall = new Chart(
                document.getElementById('monthly_overall'), {
                    type: 'bar',
                    data: { datasets: monthly_overall_datasets },
                }
            );

            // const data = [
            //     { section: 'Section A', count: 10 },
            //     { section: 'Section B', count: 20 },
            // ];

            // new Chart(
            //     document.getElementById('annual_section'), {
            //         type: 'bar',
            //         data: {
            //             labels: annual_section.data.map(row => row.section),
            //             datasets: [
            //                 {
            //                     label: 'Acquisitions by asd',
            //                     data: annual_section.data.map(row => row.count)
            //                 }
            //             ]
            //         },
            //     }
            // );


        })();
    </script>
</div>

