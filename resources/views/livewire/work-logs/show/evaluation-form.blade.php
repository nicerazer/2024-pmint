<div class="flex card-body">
    <h3 class="card-title">Nilai Aktiviti</h3>
    <form wire:submit="save">
        <label class="w-full mb-8 form-control">
            <div class="label">
                <span class="label-text">Nota</span>
            </div>
            <textarea wire:model="evaluator_comment" class="w-full textarea textarea-bordered"></textarea>
        </label>
        <h2 class="mb-1 text-sm">Status Aktivti</h2>
        <div class="mb-4 w-fit">
            <div class="form-control">
                <label class="cursor-pointer label w-fit">
                    <input type="radio" name="is_accept" value="true" class="mr-3 radio checked:bg-red-500"
                        checked />
                    <span class="label-text">Diterima</span>
                </label>
            </div>
            <div class="form-control">
                <label class="cursor-pointer label w-fit">
                    <input type="radio" name="is_accept" value="false" class="mr-3 radio checked:bg-blue-500"
                        checked />
                    <span class="label-text">Kembali</span>
                </label>
            </div>
        </div>
        <button class="w-full btn btn-primary">Disahkan</button>
    </form>
</div>
