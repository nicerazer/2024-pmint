<div class="card-body">
    <h2 class="font-bold text-gray-800 card-title">
        Cipta Bahagian
    </h2>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Nama Bahagian</span>
            </div>
            <input type="text" placeholder="Isi nama bahagian" class="w-full input input-bordered" wire:model="name">
            @error('name')
                <div class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror
        </label>
        <div class="justify-end mt-4 card-actions">
            <button type="submit" class="btn btn-primary">Cipta</button>
        </div>
    </form>

</div>
