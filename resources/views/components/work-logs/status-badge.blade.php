<div class="uppercase">
    @php
        use App\Helpers\WorkLogCodes;
        use App\Helpers\UserRoleCodes;
        use Carbon\Carbon;
    @endphp
    @props(['row'])

    {{--
    // ONGOING      0
    // SUBMITTED    1
    // TOREVISE     2
    // COMPLETED    3
    // CLOSED       4
    --}}

    {{-- Case where ongoing but past due --}}
    {{-- @if ($row->status == WorkLogCodes::ONGOING && now() > $row->expected_at)
    <span class="badge badge-error badge-sm">{{ (new Carbon($row->expected_at))->diffForHumans() }}</span> --}}
    {{-- Case where ongoing and on track --}}
    {{-- @if ($row->status == WorkLogCodes::ONGOING)
        <span class="badge badge-ghost badge-sm">{{ (new Carbon($row->expected_at))->diffForHumans() }}</span> --}}
    @if ($row->status == WorkLogCodes::ONGOING)
        <span class="text-white badge badge-info badge-sm">{{ WorkLogCodes::TRANSLATION[WorkLogCodes::ONGOING] }}</span>
        {{-- Case where to submitted --}}
    @elseif ($row->status == WorkLogCodes::SUBMITTED)
        <span class="badge badge-accent badge-sm">
            @if (auth()->user()->currentlyIs(UserRoleCodes::STAFF))
                {{ WorkLogCodes::TRANSLATION[WorkLogCodes::SUBMITTED] }}
            @elseif (auth()->user()->currentlyIs(UserRoleCodes::EVALUATOR_1))
                Dihantar pada {{ (new Carbon($row->expected_at))->diffForHumans() }}
            @endif
        </span>
        {{-- Case where to revise --}}
    @elseif ($row->status == WorkLogCodes::TOREVISE)
        <span class="badge badge-warning badge-sm">{{ WorkLogCodes::TRANSLATION[WorkLogCodes::TOREVISE] }}</span>
        {{-- Case where to revise --}}
    @elseif ($row->status == WorkLogCodes::COMPLETED)
        <span
            class="text-white badge badge-primary badge-sm">{{ WorkLogCodes::TRANSLATION[WorkLogCodes::COMPLETED] }}</span>
    @elseif ($row->status == WorkLogCodes::CLOSED)
        <span class="badge badge-neutral badge-sm">{{ WorkLogCodes::TRANSLATION[WorkLogCodes::CLOSED] }}</span>
    @elseif ($row->status == WorkLogCodes::REVIEWED)
        <span
            class="text-white badge badge-success badge-sm">{{ WorkLogCodes::TRANSLATION[WorkLogCodes::REVIEWED] }}</span>
    @else
        <span class="badge badge-ghost badge-sm">error!</span>
    @endif

</div>
