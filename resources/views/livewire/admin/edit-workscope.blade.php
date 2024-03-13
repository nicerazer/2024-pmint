<div class="card-body">
    <h2 class="card-title">Kemaskini Aktiviti</h2>
    {{-- {{ $model_id }}
    {{ $workscope_title }} --}}
    @if ($workscope)
        <form wire:submit="save">
            <div class="mb-3">
                <h2 class="mb-1 label-text">Tukar Asal</h2>
                <h2 class="text-lg">{{ $workscope->title }}</h2>
            </div>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Tukar kepada</span>
                </div>
                <input type="text" placeholder="Isi tajuk aktiviti" class="w-full input input-bordered"
                    wire:model="title" value="{{ $workscope->title }}" />
                @error('title')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>

            <div class="justify-end mt-4 card-actions">
                <button class="btn btn-primary">Hantar</button>
            </div>
        </form>
    @else
        Skop kerja tidak dapat diambil dalam sistem. Sila 'refresh' page ini.
    @endif
</div>
