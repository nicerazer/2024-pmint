<div class="card-body">
    @php
        use App\Helpers\UserRoleCodes;
    @endphp

    <h2 class="card-title">Kemaskini Staff</h2>
    {{-- {{ $form->selected_section_id }}
    {{ $form->selected_unit_id }} --}}
    {{-- <div style="width: 800px;" wire:ignore><canvas id="canvas_monthly_staff"></canvas></div> --}}
    @if ($staff)

        <form wire:submit="save">
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Nama Staff</span>
                </div>
                <input wire:model="form.name" value="{{ $staff->name }}" type="text" placeholder="Isi nama unit"
                    class="w-full input input-bordered" wire:model="name" />
                @error('form.name')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">E-mel</span>
                </div>
                <input wire:model="form.email" type="text" placeholder="Isi e-mel"
                    class="w-full input input-bordered" />
                @error('form.email')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">IC Staff</span>
                </div>
                <input wire:model="form.ic" type="text" placeholder="Isi nama unit"
                    class="w-full input input-bordered" />
                @error('form.ic')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Kata Laluan</span>
                </div>
                <input wire:model="form.password" type="password" placeholder="Tinggalkan jika tidak mahu ubah"
                    class="w-full input input-bordered" wire:model="password" />
                @error('form.password')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Pilih Bahagian</span>
                </div>
                <select wire:change="switchSection($event.target.value)" wire:model="form.selected_section_id"
                    class="w-full select select-bordered">
                    <option disabled selected value="-1">Pilih Bahagian</option>
                    @foreach (App\Models\StaffSection::all() as $staff_section)
                        <option wire:key="{{ $staff_section->id }}" value="{{ $staff_section->id }}">
                            {{ $staff_section->name }}</option>
                    @endforeach
                </select>
                @error('form.selected_section_id')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Pilih Unit</span>
                </div>
                {{-- @if ($this->form->selected_section_id != 0 && $this->staffUnits->count() != 0) --}}
                @if ($this->form->selected_section_id != 0)
                    <select wire:change="switchUnit($event.target.value)" wire:model="form.selected_unit_id"
                        class="w-full select select-bordered">
                        <option disabled selected value="-1">Pilih Unit</option>
                        @foreach ($this->staff_units as $staff_unit)
                            <option wire:key="{{ $staff_unit->id }}" value="{{ $staff_unit->id }}">
                                {{ $staff_unit->name }}</option>
                        @endforeach
                    </select>
                @elseif ($this->staff_units->count() == 0)
                    <div class="w-full border border-gray-300 join">
                        <div class="flex items-center justify-center w-full h-12 gap-2 pl-4 bg-gray-200 join-item">
                            Tiada unit yang wujud
                        </div>
                    </div>
                @elseif ($this->form->selected_section_id == -1)
                    <div class="w-full border border-gray-300 join">
                        <div class="flex items-center justify-center w-full h-12 gap-2 pl-4 bg-gray-200 join-item">
                            👈 Sila pilih bahagian
                        </div>
                    </div>
                @else
                    NOINOISDNFSDF
                @endif
                {{-- Error Message --}}
                @error('form.selected_unit_id')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <h3 class="mt-4 mb-1 ml-1 font-bold">Role User</h3>
            <div class="w-fit">
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Admin</span>
                        <input wire:model="form.has_role_admin" value="yes" type="checkbox"
                            @if ($form->has_role_admin) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Penilai 1</span>
                        <input wire:model="form.has_role_evaluator_1" value="yes" type="checkbox"
                            @if ($form->has_role_evaluator_1) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Penilai 2</span>
                        <input wire:model="form.has_role_evaluator_2" value="yes" type="checkbox"
                            @if ($form->has_role_evaluator_2) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Staff</span>
                        <input wire:model="form.has_role_staff" value="yes" type="checkbox"
                            @if ($form->has_role_staff) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
            </div>

            <div class="justify-end mt-4 card-actions">
                <button class="btn btn-primary w-72">Kemaskini</button>
            </div>
        </form>

        <div class="divider"></div>

        {{-- <div class="flex justify-between"> --}}
            <div class="mb-3">
                <h3 class="mb-2 text-lg font-bold">Buang staff?</h3>
                <p class="text-gray-700">Semua log kerja berkaitan dengan staff ini akan dibuang.</p>
            </div>

            <button class="btn btn-error w-52" onclick="delete_model_modal.showModal()">Buang Staff</button>
        {{-- </div> --}}

        {{-- script not loading --}}

        <!-- Open the modal using ID.showModal() method -->
        <dialog id="delete_model_modal" class="modal">
        <div class="modal-box">
            <div class="flex items-center justify-center w-12 h-12 mx-auto text-red-500 border border-red-100 rounded bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="mb-2 text-lg font-bold text-center">Buang staff?</h3>
            <p class="py-4 text-center text-gray-700">Isi kata laluan</p>
            <div class="flex justify-center">
                <input type="password" class="w-96 input input-bordered" placeholder="Kata Laluan">
            </div>
            <div class="flex items-center justify-center gap-2 modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Batal</button>
                </form>
                <button class="btn btn-error">Buang Staff</button>
            </div>
        </div>
        </dialog>


    @else
        Sedang ambil data dari sistem...
    @endif
    @foreach ($errors->all() as $message)
        {{ $message }}
    @endforeach
    <script>
        document.addEventListener('livewire:init', () => {

            const chart = new Chart(
                document.getElementById('canvas_monthly_staff'), {
                    type: 'bar',
                    data: {
                        labels: ['Empty'],
                        datasets: [
                            {
                                label: 'Empty',
                                data: [0]
                            }
                        ]
                    },
                }
            );

            Livewire.on('change-something', (data) => {
                console.log(data[0]);
                // chart.data = [1,2,4,5,5,6,1];
                chart.data.datasets[0].data = data[0];
                chart.update();
            });
        });

    </script>
</div>

{{-- @script
@endscript --}}
