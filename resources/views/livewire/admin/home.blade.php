@php
    // $staff_sections = App\Models\StaffSection::where('id', auth()->user()->unit->staffsection->id)->get();
    $staff_sections = App\Models\StaffSection::all();
@endphp

<div x-data="{
    staff_section_id: -1,
    staff_unit_id: -1,
    staff_id: -1,
    activity_id: -1,
    model_context: 'staff_section',
    model_id: 1,
    is_creating: true,
}">
    <span x-text="model_context"></span>
    <span x-text="model_id"></span>
    <span x-text="is_creating == 1 ? 'creating' : 'editing'"></span>
    <div class="flex gap-4">
        <div class="w-full max-w-lg">
            <button class="btn btn-xs btn-primary"
                @click="
                    model_context = 'staff_section';
                    model_id = -1;
                    is_creating = true;
                ">
                Cipta Bahagian
            </button>
            <button class="btn btn-xs btn-primary"
                @click="
                    model_context = 'staff_unit';
                    model_id = -1;
                    is_creating = true;
                ">
                Cipta Unit
            </button>
            <button class="btn btn-xs btn-primary"
                @click="
                    model_context = 'staff';
                    model_id = -1;
                    is_creating = true;
                ">
                Cipta Staff
            </button>
            <button class="btn btn-xs btn-primary"
                @click="
                    model_context = 'workscope';
                    model_id = -1;
                    is_creating = true;
                ">
                Cipta Aktiviti
            </button>
        </div>
        <div class="w-full">
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a>Bahagian ????</a></li>
                    <li>Cipta Unit</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        <ul class="w-full max-w-lg rounded-lg menu menu-xs"> <!-- Treeview -->
            @foreach ($staff_sections as $staff_section)
                <li>
                    <details open>
                        <summary
                            @click="
                                model_context = 'staff_section'
                                model_id = {{ $staff_section->id }}
                                is_creating = false
                            ">
                            🏛️ Bahagian {{ $staff_section->name }}
                        </summary>
                        <ul>
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
                                                is_creating = false
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
                                                                model_context = 'staff'
                                                                model_id = {{ $staff->id }}
                                                                is_creating = false
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
                                                        @foreach ($staff_unit->workScopes as $work_scope)
                                                            <li
                                                                @click="
                                                                model_context = 'work_scope'
                                                                model_id = {{ $work_scope->id }}
                                                                is_creating = false
                                                            ">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 16 16" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path
                                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                    </svg>
                                                                    {{ $work_scope->title }}
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
        <div x-show="
            model_context == 'staff_section' && is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.create-staffsection />
        </div>
        <div x-show="
            model_context == 'staff_unit' && is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.create-staffunit />
        </div>
        <div x-show="
            model_context == 'staff' && is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.create-staff />
        </div>
        <div x-show="
            model_context == 'workscope' && is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.create-workscope />
        </div>
    </div>
</div>
