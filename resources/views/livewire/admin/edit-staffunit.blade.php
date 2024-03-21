<div class="card-body">
    <h2 class="card-title">Kemaskini Bahagian {{ $name ?? '??' }}</h2>
    @if ($staff_unit)
        <form wire:submit="save">
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Nama Unit</span>
                </div>
                <input type="text" placeholder="Isi nama unit" class="w-full input input-bordered" wire:model="name"
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
