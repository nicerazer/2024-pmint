<div class="card-body">
    <h2 class="card-title">Kemaskini Bahagian {{ $model_id }}</h2>
    @if ($staff_section)
        <form wire:submit="save">
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Nama Bahagian</span>
                </div>
                <input type="text" placeholder="Isi nama bahagian" class="w-full input input-bordered" wire:model="name"
                    value="{{ $name }}">
                @error('name')
                    <div class="label text-error">
                        <span class="label-text-alt">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <div class="justify-end mt-4 card-actions">
                <button type="submit" class="btn btn-primary">Hantar</button>
            </div>
        </form>
    @else
        Sila pilih bahagian
    @endif
</div>
