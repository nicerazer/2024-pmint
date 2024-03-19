<div class="card-body">
    @php
        use App\Helpers\UserRoleCodes;
    @endphp

    <h2 class="card-title">Kemaskini Staff</h2>
    {{ $form->selected_section_id }}
    {{ $form->selected_unit_id }}
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
                        @foreach ($this->staffUnits as $staff_unit)
                            <option wire:key="{{ $staff_unit->id }}" value="{{ $staff_unit->id }}">
                                {{ $staff_unit->name }}</option>
                        @endforeach
                    </select>
                @elseif ($this->staffUnits->count() == 0)
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
    @else
        Sedang ambil data dari sistem...
    @endif
    @foreach ($errors->all() as $message)
        {{ $message }}
    @endforeach
</div>
