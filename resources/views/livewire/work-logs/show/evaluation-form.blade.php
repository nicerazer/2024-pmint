<div class="flex card-body">
    <h3 class="mb-6 font-bold text-gray-800">Nilai Aktiviti</h3>
    <form wire:submit="save">
        <input type="text" wire:model="evaluator_comment">
        <div class="form-control">
            <label class="cursor-pointer label">
                <span class="label-text">Terima?</span>
                <input type="checkbox" checked="checked" class="checkbox checkbox-info" wire:model='is_accept' />
            </label>
        </div>
        <button>Nilai</button>
    </form>
</div>
