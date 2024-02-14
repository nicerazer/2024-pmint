<x-app-layout>
    <x-slot:header>

    </x-slot:header>

    <ul class="w-full max-w-xs rounded-lg menu menu-xs bg-base-200">
        @foreach ($staff_sections as $staff_section)
            <li>
                <details open>
                    <summary>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                        {{ $staff_section->name }}
                    </summary>
                    <ul>
                        @foreach ($staff_section->staffUnits as $staff_unit)
                            <li>
                                <details open>
                                    <summary>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                        </svg>
                                        {{ $staff_unit->name }}
                                    </summary>
                                    <ul>
                                        <li>
                                            <details open>
                                                <summary>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                                    </svg>
                                                    Penilai 1
                                                </summary>
                                                <ul>
                                                    @foreach ($staff_unit->evaluator1s as $evaluator1)
                                                        <li><a>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 16 16" fill="currentColor"
                                                                    class="w-4 h-4">
                                                                    <path
                                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                </svg>
                                                                {{ $evaluator1->name }}
                                                            </a></li>
                                                    @endforeach
                                                </ul>
                                            </details>
                                        </li>
                                        <li>
                                            <details open>
                                                <summary>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                                    </svg>
                                                    Penilai 2
                                                </summary>
                                                <ul>
                                                    @foreach ($staff_unit->evaluator2s as $evaluator2)
                                                        <li><a>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 16 16" fill="currentColor"
                                                                    class="w-4 h-4">
                                                                    <path
                                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                </svg>
                                                                {{ $evaluator2->name }}
                                                            </a></li>
                                                    @endforeach
                                                </ul>
                                            </details>
                                        </li>
                                        <li>
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
                                                        <li><a>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 16 16" fill="currentColor"
                                                                    class="w-4 h-4">
                                                                    <path
                                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                </svg>
                                                                {{ $staff->name }}
                                                            </a></li>
                                                    @endforeach

                                                </ul>
                                            </details>
                                        </li>
                                        <li>
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
                                                        <li><a>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 16 16" fill="currentColor"
                                                                    class="w-4 h-4">
                                                                    <path
                                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
                                                                </svg>
                                                                {{ $work_scope->title }}
                                                            </a></li>
                                                    @endforeach

                                                </ul>
                                            </details>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        @endforeach
                    </ul>
                </details>
            </li>
        @endforeach
    </ul>
    {{-- <div style="width: 800px;"><canvas id="report"></canvas></div> --}}
</x-app-layout>
