<div class="card-body">

    <h2 class="font-bold text-gray-800 card-title">
        Tambah Staf
    </h2>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Bahagian</span>
            </div>
            <select class="w-full select select-bordered" wire:change="switchSection($event.target.value)">
                <option disabled selected value="-1">Pilih Bahagian</option>
                @foreach (App\Models\StaffSection::all() as $staff_section)
                    <option value="{{ $staff_section->id }}">
                        {{ $staff_section->name }}</option>
                @endforeach
            </select>
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Unit</span>
            </div>

            <select class="w-full select select-bordered" wire:model.live="form.selected_unit_id">
                <option disabled selected value="-1">Pilih Unit</option>
                @foreach ($this->staff_units as $staff_unit)
                    <option value="{{ $staff_unit->id }}">{{ $staff_unit->name }}</option>
                @endforeach
            </select>

            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Nama Staff</span>
            </div>
            <input type="text" placeholder="Isi nama staff" class="w-full input input-bordered"
                wire:model="form.name" />
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">IC</span>
            </div>
            <input type="text" placeholder="Isi no ic" class="w-full input input-bordered" wire:model="form.ic" />
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Email</span>
            </div>
            <input type="text" placeholder="Isi email" class="w-full input input-bordered" wire:model="form.email" />
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Password</span>
            </div>
            <input type="password" placeholder="Isi kata laluan" class="w-full input input-bordered"
                wire:model="form.password" />
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <h3 class="mt-6 mb-1 ml-1 text-lg font-bold">Mod Pengguna</h3>
        <div class="w-fit">
            <div class="form-control">
                <label class="cursor-pointer label">
                    <span class="mr-8 label-text">Admin</span>
                    <input wire:model="form.has_role_admin" value="yes" type="checkbox"
                        @if ($form->has_role_admin) checked="checked" @endif class="checkbox checkbox-primary" />
                </label>
            </div>

            <div class="form-control">
                <label class="cursor-pointer label">
                    <span class="mr-8 label-text">Penilai 2</span>
                    <input wire:model="form.has_role_evaluator_2" value="yes" type="checkbox"
                        @if ($form->has_role_evaluator_2) checked="checked" @endif class="checkbox checkbox-primary" />
                </label>
            </div>
            <div class="form-control">
                <label class="cursor-pointer label">
                    <span class="mr-8 label-text">Penilai 1</span>
                    <input wire:model="form.has_role_evaluator_1" value="yes" type="checkbox"
                        @if ($form->has_role_evaluator_1) checked="checked" @endif class="checkbox checkbox-primary" />
                </label>
            </div>
            <div class="form-control">
                <label class="cursor-pointer label">
                    <span class="mr-8 label-text">Staff</span>
                    <input wire:model="form.has_role_staff" value="yes" type="checkbox"
                        @if ($form->has_role_staff) checked="checked" @endif class="checkbox checkbox-primary" />
                </label>
            </div>
        </div>

        <div class="justify-end mt-4 card-actions">
            <button class="btn btn-primary">Cipta</button>
        </div>
        @foreach ($errors->all() as $message)
            {{ $message }}
        @endforeach
    </form>

</div>
