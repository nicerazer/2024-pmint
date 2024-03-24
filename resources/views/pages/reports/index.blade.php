<x-app-layout>
    <div style="width: 800px;"><canvas id="acquisitions"></canvas></div>
    {{-- @dump($data) --}}

    <script>
            // const notData = {{ Js::from($data) }};
            // const data = [{'x': 'Jan', 'Staff A': 100, 'Staff B': 50, 'Staff C': 50}, {'x': 'Feb', 'Staff A': 120, 'Staff B': 55, 'Staff C': 75}];

    </script>

    <script type="module">
        (async function() {
            // const data = [{x: 'Jan', net: 100, cogs: 50, gm: 50}, {x: 'Feb', net: 120, cogs: 55, gm: 75}];
            // const data = [{'x': 'Jan', 'Staff A': 100, 'Staff B': 50, 'Staff C': 50}, {'x': 'Feb', 'Staff A': 120, 'Staff B': 55, 'Staff C': 75}];
            const data = {{ Js::from($data) }};

            new Chart(
                document.getElementById('acquisitions'), {
                    type: 'bar',
                    // data: {
                    //     labels: data.map(row => row.date),
                    //     datasets: [{
                    //         label: 'Acquisitions by year',
                    //         data: data.map(row => row.count)
                    //     }]
                    // }
                    data: {
    labels: ['Jan', 'Feb'],
    datasets: [{
      label: 'Staff A',
      data: data,
      parsing: {
        yAxisKey: 'Staff A'
      }
    }, {
      label: 'Staff B',
      data: data,
      parsing: {
        yAxisKey: 'Staff B'
      }
    }, {
      label: 'Staff C',
      data: data,
      parsing: {
        yAxisKey: 'Staff C'
      }
    }]
  },
                }
            );

        })();
    </script>
</x-app-layout>
