<div class="flex card-body">
    <h3 class="card-title">Nilai Aktiviti</h3>
    <form wire:submit="save">
        <label class="w-full mb-2 form-control">
            <div class="label">
                <span class="label-text">Nota</span>
            </div>
            <textarea wire:model="evaluator_comment" class="w-full textarea textarea-bordered"></textarea>
        </label>
        <div class="mb-4 form-control">
            <label class="gap-2 cursor-pointer label w-fit">
                <span class="label-text">Terima Penghantaran Aktiviti?</span>
                <input type="checkbox" checked="checked" class="checkbox checkbox-info" wire:model='is_accept' />
            </label>
        </div>
        <button class="w-full max-w-xs btn btn-primary">Disahkan</button>
    </form>
</div>
