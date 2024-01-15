@php
    use Illuminate\Support\Facades\Route;
    use App\Helpers\UserRoleCodes;
    use App\Helpers\WorkLogCodes;
@endphp
<tbody>
    @foreach ($worklogs as $worklog)
        <tr wire:key="{{ $worklog->id }}">
            <th>
                <label>
                    <input type="checkbox" class="checkbox"
                        wire:click="bulkEditQueue({{ $worklog->id }}, event.target.checked)" />
                </label>
            </th>

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
            {{-- @if (Route::currentRouteName() == 'home') --}}
            {{-- <x-table-partials.td-staff :$worklog :$status_index /> --}}
            {{-- @elseif (Route::currentRouteName() == 'home.evaluator-1')
                <x-table-partials.td-evaluator-1 :$worklog />
            @elseif (Route::currentRouteName() == 'home.evaluator-2')
                <x-table-partials.td-evaluator-2 :$worklog />
            @endif --}}
            {{-- @elseif (Route::currentRouteName() == 'home.admin') --}}
            {{-- <x-dynamic-component :component="$componentName" class="mt-4" /> --}}

            <th class="flex justify-end">
                {{-- <button class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button> --}}

                {{-- If evaluators they can just approve, there is a button, rating option, and comment box --}}
                {{-- If staffs they can submit here.. Maybe? What about file uploads? --}}

                {{-- <button class="btn btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5">
                                            <path
                                                d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                        </svg>
                                    </button> --}}
                {{-- <div class="divider-vertical"></div> <!-- idk lol try look at it first --> --}}
                <a class="btn btn-ghost" href="/logkerja/{{ $worklog->id }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </th>
        </tr>
    @endforeach
</tbody>
