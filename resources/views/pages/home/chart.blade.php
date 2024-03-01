<x-app-layout>
    <x-slot:header>

    </x-slot:header>

    {{-- <div style="width: 800px;"><canvas id="report"></canvas></div> --}}

    @push('scripts')
        <script type="module">
            (async function() {
                const data = [{
                        staffsection: 'Bahagian Pentadbiran & Sumber Manusia',
                        count: 10
                    },
                    {
                        staffsection: 'Bahagian A',
                        count: 20
                    },
                    {
                        staffsection: 'Bahagian B',
                        count: 15
                    },
                    {
                        staffsection: 'Bahagian C',
                        count: 25
                    },
                    {
                        staffsection: 'Bahagian D',
                        count: 22
                    },
                    {
                        staffsection: 'Bahagian E',
                        count: 30
                    },
                    {
                        staffsection: 'Bahagian F',
                        count: 28
                    },
                ];

                new Chart(
                    document.getElementById('report'), {
                        type: 'bar',
                        data: {
                            labels: data.map(row => row.staffsection),
                            datasets: [{
                                label: 'Log aktiviti tahun 2024',
                                data: data.map(row => row.count)
                            }]
                        }
                    }
                );
            })();
        </script>
    @endpush
</x-app-layout>
