<x-app-layout>
    <div style="width: 800px;"><canvas id="monthly_staff"></canvas></div>
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
</x-app-layout>
