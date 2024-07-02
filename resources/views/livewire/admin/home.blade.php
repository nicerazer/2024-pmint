<div x-data="{
    staff_section_id: -1,
    staff_unit_id: -1,
    staff_id: -1,
    activity_id: -1,
    model_context: '{{ $model_context }}',
    model_id: {{ $model_id }},
    is_creating: {{ $model_is_creating ? 1 : 0 }} == 1 ? true : false,
    staff_sections: {{ Illuminate\Support\Js::from($this->staff_sections) }}
}">
    <!-- Create Menu / Breadcrumbs START -->
    <section class="flex gap-4">
        <div class="w-full max-w-lg">
            <div role="tablist" class="tabs tabs-bordered">
                <a role="tab" class="tab" :class="{ 'tab-active': is_creating && model_context == 'staff_section' }" @click="
                    model_context = 'staff_section';
                    model_id = -1;
                    is_creating = true;
                ">Cipta Bahagian</a>
                <a role="tab" class="tab" :class="{ 'tab-active': is_creating && model_context == 'staff_unit' }" @click="
                    model_context = 'staff_unit';
                    model_id = -1;
                    is_creating = true;
                ">Cipta Unit</a>
                <a role="tab" class="tab" :class="{ 'tab-active': is_creating && model_context == 'staff' }" @click="
                    model_context = 'staff';
                    model_id = -1;
                    is_creating = true;
                ">Tambah Staff</a>
                <a role="tab" class="tab" :class="{ 'tab-active': is_creating && model_context == 'workscope' }" @click="
                    model_context = 'workscope';
                    model_id = -1;
                    is_creating = true;
                ">Tambah Aktiviti</a>
            </div>
        </div>

        <!-- TODO: Breadcrumbs -->
        <div class="w-full">
            <div class="text-sm breadcrumbs">
                <ul>
                    {{-- <li><a>Bahagian&nbsp;<span x-text="staff_sections[staff_section_id].name"></span></a></li> --}}
                    {{-- Model context --}}
                    {{-- <li x-show="model_context == '' && !is_creating"><a>Bahagian&nbsp;<span x-text="staff_sections[staff_section_id].name"></span></a></li>
                    <li x-show="model_context == 'staff_unit' && is_creating">
                        Bahagian A
                    </li>
                    <li x-show="model_context == 'staff_unit' && is_creating">
                        Unit
                    </li>
                    <li x-show="model_context == 'staff_unit' && is_creating">
                        Bahagian A
                    </li>

                    <!-- Creating crumbs -->
                    <li x-show="model_context == 'staff_unit' && is_creating">Cipta Bahagian</li>
                    <li x-show="model_context == 'staff_unit' && is_creating">Cipta Unit</li>
                    <li x-show="model_context == 'staff_unit' && is_creating">Cipta Staf</li>
                    <li x-show="model_context == 'workscope' && is_creating">Cipta Aktiviti</li> --}}
                </ul>
            </div>
        </div>
    </section>
    <!-- Create Menu / Breadcrumbs END -->

    <!-- Treeview / Mainview START -->
    <section class="flex gap-4">
        <livewire:navigation.admin-treeview :$staff_sections />

        <div x-show="model_context == 'init'" class="w-full">
            <h2 class="w-[28rem] mx-auto mt-20 mb-12 text-lg font-medium text-center">👈 Sila klik mana-mana data untuk edit atau item dari menu penciptaan</h2>
            <img src="{{ asset('assets/empty/6-empty.png') }}" alt="" class="max-w-[30rem] mx-auto">
        </div>

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
        {{-- Edit windows --}}
        <div x-show="
            model_context == 'workscope' && !is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.edit-workscope :$model_id />
        </div>
        <div x-show="
            model_context == 'staff' && !is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.edit-staff :$model_id />
        </div>
        <div x-show="
            model_context == 'staff_section' && !is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.edit-staffsection :$model_id />
        </div>
        <div x-show="
            model_context == 'staff_unit' && !is_creating
        " x-cloak
            class="w-full bg-white border card h-fit">
            <livewire:admin.edit-staffunit :$model_id />
        </div>
    </section>
    <!-- Treeview / Mainview END -->
</div>

{{-- @script --}}
<script type="module">
    (async function () {
        // Data from back end for bridge
        // Event listener for model change
        // Refresh the mapping, re-execute function
        // // When to refresh? When the component refresh via Livewire

        // Methods to bind data
        // 1. Sync using morph
        // --- Listener
        // 2. Sync through alpinejs
        // --- Listener
        // --- Internal props
        // document.addEventListener(('wire:init') => {

        // })
    })();
</script>
{{-- @endscript --}}
