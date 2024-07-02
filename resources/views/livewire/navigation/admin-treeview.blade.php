        <ul class="w-full max-w-lg rounded-lg menu menu-xs"> <!-- Treeview -->
            @foreach ($staff_sections as $staff_section)
                <li>
                    <details open>
                        <summary wire:ignore
                            @click="
                                model_context = 'staff_section';
                                model_id = {{ $staff_section->id }};
                                is_creating = false;
                                $wire.$parent.set('model_id', {{ $staff_section->id }});
                            ">
                            🏛️ Bahagian {{ $staff_section->name }}
                        </summary>
                        <ul wire:ignore>
                            @php $ev1s = App\Models\User::evaluator1s($staff_section->id);
                                 $ev2s = App\Models\User::evaluator2s($staff_section->id);
                            @endphp
                            <li> <!-- Penilai 2 -->
                                <details open>
                                    <summary>
                                        👮 Penilai 2
                                    </summary>
                                    <ul>
                                        @foreach ($ev2s as $ev2)
                                            <li @click="
                                                model_context = 'staff';
                                                model_id = {{ $ev2->id }};
                                                is_creating = false;
                                                $wire.$parent.set('model_id', {{ $ev2->id }});
                                            "><span>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path
                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                </svg>
                                                {{ $ev2->name }}
                                            </span></li>
                                        @endforeach
                                    </ul>
                                </details>
                            </li> <!-- Penilai 2 -->

                            <li> <!-- Penilai 1 -->
                                <details open>
                                    <summary>
                                        👮 Penilai 1
                                    </summary>
                                    <ul>
                                        @foreach ($ev1s as $ev1)
                                            <li @click="
                                                model_context = 'staff';
                                                model_id = {{ $ev1->id }};
                                                is_creating = false;
                                                $wire.$parent.set('model_id', {{ $ev1->id }});
                                            "><span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path
                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                    </svg>
                                                    {{ $ev1->name }}
                                            </span></li>
                                        @endforeach
                                    </ul>
                                </details>
                            </li> <!-- Penilai 1 -->

                            @foreach ($staff_section->staffUnits as $staff_unit)
                                <li>
                                    <details open>
                                        <summary
                                            @click="
                                                model_context = 'staff_unit'
                                                model_id = {{ $staff_unit->id }}
                                                is_creating = false
                                                $wire.$parent.set('model_id', {{ $staff_unit->id }})
                                                $wire.dispatch('switched-unit', { staff_unit_id: {{ $staff_unit->id }} });
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
                                                                model_context = 'staff';
                                                                model_id = {{ $staff->id }};
                                                                is_creating = false;
                                                                $wire.$parent.set('model_id', {{ $staff->id }});
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
                                                        @foreach ($staff_unit->workScopes as $workscope)
                                                            <li
                                                                @click="
                                                                model_context = 'workscope';
                                                                model_id = {{ $workscope->id }};
                                                                is_creating = false;
                                                                $wire.$parent.set('model_id', {{ $workscope->id }});
                                                            ">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 16 16" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path
                                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                    </svg>
                                                                    {{ $workscope->title }}
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
