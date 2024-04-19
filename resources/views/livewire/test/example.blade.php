<div>
    {{-- <div x-ignore>From alpinejs: <span x-text="other_monthly_staff[0].count"></span></div> --}}
    {{-- <div x-ignore>From livewire: {{ $report_monthly_staff[0]['count'] }}</div> --}}
    {{-- <button x-ignore class="btn btn-primary" @click="chart.update()">updateee</button> --}}
    <button x-ignore class="btn btn-primary" wire:click="changesomething">asdasdads</button>
    <div style="width: 800px;"><canvas id="other_monthly_staff"></canvas></div>
</div>

{{-- @script --}}
<script>

    // document.addEventListener('alpine:init', () => {
    // const chart = new Chart(document.querySelector("[refs='other_monthly_staff']"), {
    //     type: 'bar',
    //     data: {
    //         labels: {{ Js::from($report_monthly_staff) }}.map(row => row.year),
    //         datasets: [
    //             {
    //                 label: 'Acquisitions by year',
    //                 data: {{ Js::from($report_monthly_staff) }}.map(row => row.count)
    //             }
    //         ]
    //     }
    // });
    document.addEventListener('livewire:init', () => {

    // const monthly_staff = {{ Js::from($report_monthly_staff) }};

    const chart = new Chart(
        document.getElementById('other_monthly_staff'), {
            type: 'bar',
            data: {
                labels: {{ Js::from($report_monthly_staff) }}.map(row => row.month),
                datasets: [
                    {
                        label: 'Acquisitions by year',
                        data: {{ Js::from($report_monthly_staff) }}.map(row => row.count)
                    }
                ]
            },
        }
    );

    Livewire.on('change-something', () => {
        alert('nice');
        chart.update();
    });
        // })
    // });
    // Livewire.on('updateChart', data => {
    //     chart.data = data;
    //     chart.update();
    });

</script>
{{-- @endscript --}}
