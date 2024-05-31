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
        <ul class="w-full max-w-lg rounded-lg menu menu-xs"> <!-- Treeview -->
            @foreach ($staff_sections as $staff_section)
                <li>
                    <details open>
                        <summary wire:ignore
                            @click="
                                model_context = 'staff_section'
                                model_id = {{ $staff_section->id }}
                                $wire.set('model_id', {{ $staff_section->id }})
                            ">
                            🏛️ Bahagian {{ $staff_section->name }}
                        </summary>
                        <ul wire:ignore>
                            <li> <!-- Penilai 1 -->
                                <details open>
                                    <summary>
                                        👮 Penilai 1
                                    </summary>
                                    <ul>
                                        @if ($staff_section->evaluator1)
                                            <li><a>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path
                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                    </svg>
                                                    {{ $staff_section->evaluator1->name }}
                                                </a></li>
                                        @endif
                                    </ul>
                                </details>
                            </li> <!-- Penilai 1 -->
                            <li> <!-- Penilai 2 -->
                                <details open>
                                    <summary>
                                        👮 Penilai 2
                                    </summary>
                                    <ul>
                                        @if ($staff_section->evaluator2)
                                            <li><a class="active">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path
                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                    </svg>
                                                    {{ $staff_section->evaluator2->name }}
                                                </a></li>
                                        @endif
                                    </ul>
                                </details>
                            </li> <!-- Penilai 2 -->

                            @foreach ($staff_section->staffUnits as $staff_unit)
                                <li>
                                    <details open>
                                        <summary
                                            @click="
                                                model_context = 'staff_unit'
                                                model_id = {{ $staff_unit->id }}
                                                $wire.set('model_id', {{ $staff_unit->id }})
                                            ">
                                            🎫 Unit {{ $staff_unit->name }}
                                        </summary>
                                        <ul>
                                            <li> <!-- Staff -->
                                                <details open>
                                                    <summary>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                                        </svg>
                                                        Staff
                                                    </summary>
                                                    <ul>
                                                        @foreach ($staff_unit->staffs as $staff)
                                                            <li
                                                                @click="
                                                                model_context = 'staff';
                                                                model_id = {{ $staff->id }};;
                                                                $wire.set('model_id', {{ $staff->id }});
                                                            ">
                                                                <span>

                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 16 16" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path
                                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                    </svg>
                                                                    {{ $staff->name }}

                                                                </span>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </details>
                                            </li> <!-- Staff -->
                                            <li> <!-- Aktiviti -->
                                                <details open>
                                                    <summary>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                                        </svg>
                                                        Aktiviti
                                                    </summary>
                                                    <ul>
                                                        @foreach ($staff_unit->workScopes as $workscope)
                                                            <li
                                                                @click="
                                                                model_context = 'workscope';
                                                                model_id = {{ $workscope->id }};;
                                                                $wire.set('model_id', {{ $workscope->id }});
                                                            ">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 16 16" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path
                                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                    </svg>
                                                                    {{ $workscope->title }}
                                                                </span>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </details>
                                            </li> <!-- Aktiviti -->
                                        </ul>
                                    </details>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                </li>
            @endforeach
        </ul>
        {{-- Edit windows --}}
        <div x-show="model_context == 'workscope'" x-cloak class="w-full bg-white border card h-fit">
            <livewire:admin.edit-workscope :$model_id />
        </div>
        <div x-show="model_context == 'staff'" x-cloak class="w-full bg-white border card h-fit">
            {{-- <livewire:admin.edit-staff :$model_id /> --}}
            <div style="width: 800px;" wire:ignore><canvas id="monthly_staff"></canvas></div>
            asdas
        </div>
        <div x-show="model_context == 'staff_section'" x-cloak class="w-full bg-white border card h-fit">
            <livewire:admin.edit-staffsection :$model_id />
        </div>
        <div x-show="model_context == 'staff_unit'" x-cloak class="w-full bg-white border card h-fit">
            <livewire:admin.edit-staffunit :$model_id />
        </div>
    </div>



    <div style="width: 800px;"><canvas id="monthly_unit"></canvas></div>
    <div style="width: 800px;"><canvas id="monthly_section"></canvas></div>
    <div style="width: 800px;"><canvas id="monthly_overall"></canvas></div>
    <div style="width: 800px;"><canvas id="annual_section"></canvas></div>
    {{-- @dump($data) --}}

    <livewire:test.example>

    <script type="module">
        (async function() {

            // let monthly_staff_datasets = [];

            const monthly_staff = {{ Js::from($monthly_staff) }};

            const monthly_unit = {{ Js::from($monthly_unit) }};
            let monthly_unit_datasets = [];

            const monthly_section = {{ Js::from($monthly_section) }};
            let monthly_section_datasets = [];

            const monthly_overall = {{ Js::from($monthly_overall) }};
            let monthly_overall_datasets = [];

            const annual_section = {{ Js::from($annual_section) }};

            // monthly_staff.labels.forEach(label => {
            //     monthly_staff_datasets.push({
            //         label: label,
            //         data: monthly_staff.data,
            //         parsing: {
            //             yAxisKey: label
            //         }
            //     });
            // });
            // const data = [
            //     { month: 'Jan', count: 10 },
            //     { month: 'Feb', count: 20 },
            //     { month: 'Feb', count: 15 },
            //     { month: 'Feb', count: 25 },
            //     { month: 'Feb', count: 22 },
            //     { month: 'Feb', count: 30 },
            //     { month: 'Feb', count: 28 },
            // ];

            new Chart(
                document.getElementById('monthly_staff'), {
                    type: 'bar',
                    data: {
                        labels: monthly_staff.data.map(row => row.month),
                        datasets: [
                            {
                                label: 'Acquisitions by year',
                                data: monthly_staff.data.map(row => row.count)
                            }
                        ]
                    },
                }
            );

            monthly_unit.labels.forEach(label => {
                monthly_unit_datasets.push({
                    label: label,
                    data: monthly_unit.data,
                    parsing: {
                        yAxisKey: label
                    }
                });
            });

            new Chart(
                document.getElementById('monthly_unit'), {
                    type: 'bar',
                    data: { datasets: monthly_unit_datasets },
                }
            );

            monthly_section.labels.forEach(label => {
                monthly_section_datasets.push({
                    label: label,
                    data: monthly_section.data,
                    parsing: {
                        yAxisKey: label
                    }
                });
            });

            new Chart(
                document.getElementById('monthly_section'), {
                    type: 'bar',
                    data: { datasets: monthly_section_datasets },
                }
            );

            monthly_overall.labels.forEach(label => {
                monthly_overall_datasets.push({
                    label: label,
                    data: monthly_overall.data,
                    parsing: {
                        yAxisKey: label
                    }
                });
            });

            new Chart(
                document.getElementById('monthly_overall'), {
                    type: 'bar',
                    data: { datasets: monthly_overall_datasets },
                }
            );

            const data = [
                { section: 'Section A', count: 10 },
                { section: 'Section B', count: 20 },
            ];

            new Chart(
                document.getElementById('annual_section'), {
                    type: 'bar',
                    data: {
                        labels: annual_section.data.map(row => row.section),
                        datasets: [
                            {
                                label: 'Acquisitions by asd',
                                data: annual_section.data.map(row => row.count)
                            }
                        ]
                    },
                }
            );


        })();
    </script>
</div>

