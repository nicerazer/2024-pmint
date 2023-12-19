<table class="table">
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Jumlah Kerja</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($infiniteMonths as $infiniteMonth)
            <tr>
                <th>{{ $infiniteMonth['title'] }}</th>
                <td>{{ $infiniteMonth['total'] }}</td>
                <td><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="w-5 h-5 link link-hover link-primary">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                </td>
            </tr>
        @endforeach
        <tr>
            {{-- <th><span class="h-60" x-intersect="$wire.loadMoreMonths()"></span></th> --}}
            <th><span class="h-60"></span></th>
            <td><span class="h-60"></span></td>
            <td><span class="h-60"></span></td>
        </tr>
    </tbody>
</table>