<div class="card-body">
    <h2 class="font-bold text-gray-800 card-title">
        Cipta Unit
    </h2>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Nama Unit</span>
            </div>
            <input type="text" placeholder="Isi nama unit" class="w-full input input-bordered" wire:model="name" />
            @error('name')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Bahagian</span>
            </div>
            <select class="w-full select select-bordered" wire:model="staff_section_id">
                <option disabled selected value="0">Pilih Bahagian</option>
                @foreach (App\Models\StaffSection::all() as $staff_section)
                    <option value="{{ $staff_section->id }}">{{ $staff_section->name }}</option>
                @endforeach
            </select>
            @error('staff_section_id')
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
