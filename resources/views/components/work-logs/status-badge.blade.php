<div>
    @php
        use App\Helpers\WorkLogHelper;
        use Carbon\Carbon;
    @endphp
    {{--
    // ONGOING      0
    // SUBMITTED    1
    // TOREVISE     2
    // COMPLETED    3
    // CLOSED       4
    --}}

    {{-- Case where ongoing but past due --}}
    {{-- @if ($worklog->status == WorkLogHelper::ONGOING && now() > $worklog->expected_at)
    <span class="badge badge-error badge-sm">{{ (new Carbon($worklog->expected_at))->diffForHumans() }}</span> --}}
    {{-- Case where ongoing and on track --}}
    {{-- @if ($worklog->status == WorkLogHelper::ONGOING)
        <span class="badge badge-ghost badge-sm">{{ (new Carbon($worklog->expected_at))->diffForHumans() }}</span> --}}
    @if ($worklog->status == WorkLogHelper::ONGOING)
        <span class="text-white badge badge-info badge-sm">Sedang Berjalan</span>
        {{-- Case where to submitted --}}
    @elseif ($worklog->status == WorkLogHelper::SUBMITTED)
        <span class="badge badge-accent badge-sm">Submitted
            {{ (new Carbon($worklog->expected_at))->diffForHumans() }}</span>
        {{-- Case where to revise --}}
    @elseif ($worklog->status == WorkLogHelper::TOREVISE)
        <span class="badge badge-warning badge-sm">To revise</span>
        {{-- Case where to revise --}}
    @elseif ($worklog->status == WorkLogHelper::COMPLETED)
        <span class="text-white badge badge-success badge-sm">Completed</span>
    @elseif ($worklog->status == WorkLogHelper::CLOSED)
        <span class="badge badge-neutral badge-sm">Closed</span>
    @else
        <span class="badge badge-ghost badge-sm">error!</span>
    @endif

</div>
