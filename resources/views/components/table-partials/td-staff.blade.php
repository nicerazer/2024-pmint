@php
    use App\Helpers\UserRoleCodes;
    use App\Helpers\WorkLogCodes;
@endphp

@props(['worklog', 'status_index'])

@if ($status_index == WorkLogCodes::ONGOING)

    <td>
        {{-- --}}
        <div class="flex items-center space-x-3">
            <div>
                <div class="font-bold">
                    @if ($worklog->workscope)
                        {{ $worklog->workscope->title }}
                    @else
                        {{ $worklog->workscope_alternative ?: 'Skop kerja tidak di set' }}
                    @endif
                    <span class="text-sm text-gray-400">No #{{ $worklog->id }}</span>
                </div>
                @if (session(['selected_role_id']) == UserRoleCodes::ADMIN)
                    <div class="text-sm opacity-50">{{ $worklog->author->name }}</div>
                @endif
            </div>
        </div>
    </td>
    <td class="text-center">
        <x-work-logs.status-badge :worklog='$worklog' />
    </td>
    <td class="text-right">
        <span>12 Nov, 2023</span><br>
        <span>11:40pm</span>
    </td>
@else
@endif
