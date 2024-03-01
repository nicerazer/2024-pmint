<div class="card-body">
    <h2 class="card-title">Kemaskini Staff</h2>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Nama Staff</span>
            </div>
            <input type="text" placeholder="Isi nama unit" class="w-full input input-bordered" wire:model="name" />
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">IC Staff</span>
            </div>
            <input type="text" placeholder="Isi nama unit" class="w-full input input-bordered" wire:model="email" />
            @if (false)
                <div class="label">
                    <span class="label-text-alt">{{ $errorMessage }}</span>
                </div>
            @endif
        </label>
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Pilih Bahagian</span>
            </div>
            <select class="w-full select select-bordered">
                <option disabled selected>Pilih Bahagian</option>
                @foreach (App\Models\StaffSection::all() as $staff_section)
                    <option value="{{ $staff_section->id }}">{{ $staff_section->name }}</option>
                @endforeach
            </select>
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
