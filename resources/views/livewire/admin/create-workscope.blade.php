<div class="card-body">

    <h2 class="font-bold text-gray-800 card-title">
        Tambah Aktiviti
    </h2>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Bahagian</span>
            </div>
            <select class="w-full select select-bordered" wire:change="switchSection($event.target.value)">
                <option disabled selected>Pilih Bahagian</option>
                @foreach (App\Models\StaffSection::all() as $staff_section)
                    <option value="{{ $staff_section->id }}">
                        {{ $staff_section->name }}</option>
                @endforeach
            </select>
            @error('selected_section_id')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Unit</span>
            </div>
            @if ($selected_section_id == -1)
                <div class="flex items-center w-full h-12 px-3 border-2 rounded-md bg-slate-200">Sila pilih bahagian
                </div>
            @else
                <select class="w-full select select-bordered" wire:model.live="selected_unit_id">
                    <option disabled selected value="-1">Pilih Unit</option>
                    @foreach ($this->staff_units as $staff_unit)
                        <option value="{{ $staff_unit->id }}">{{ $staff_unit->name }}</option>
                    @endforeach
                </select>
            @endif

            @error('selected_unit_id')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Tajuk Aktiviti</span>
            </div>
            <input type="text" placeholder="Isi tajuk aktiviti" class="w-full input input-bordered"
                wire:model="title" />
            @error('title')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror
        </label>

        <div class="justify-end mt-4 card-actions">
            <button class="btn btn-primary">Cipta</button>
        </div>
    </form>

</div>
