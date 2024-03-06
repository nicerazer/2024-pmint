<div class="card-body">
    <h2 class="card-title">Tambah Staff</h2>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Bahagian ({{ $form->selected_section_id }})</span>
            </div>
            <select class="w-full select select-bordered" wire:change="switchSection($event.target.value)">
                <option disabled selected>Pilih Bahagian</option>
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
                <span class="label-text">Pilih Unit {{ $form->selected_unit_id }}</span>
            </div>
            @if ($form->selected_section_id == -1)
                <div class="flex items-center w-full h-12 px-3 border-2 rounded-md bg-slate-200">Sila pilih bahagian
                </div>
            @else
                <select class="w-full select select-bordered" wire:model.live="form.selected_unit_id">
                    <option disabled selected>Pilih Unit</option>
                    @foreach ($this->staff_units as $staff_unit)
                        <option value="{{ $staff_unit->id }}">{{ $staff_unit->name }}</option>
                    @endforeach
                </select>
            @endif

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

        <div class="justify-end mt-4 card-actions">
            <button class="btn btn-primary">Cipta</button>
        </div>
    </form>

</div>
