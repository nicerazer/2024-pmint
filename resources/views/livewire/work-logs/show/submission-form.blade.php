<div class="flex card-body">
    <h3 class="mb-6 font-bold text-gray-800">Hantar Kerja</h3>
    <form wire:submit="save">
        <input type="text" wire:model="body">
        <input type="file" id="file-upload" wire:model="fileponds" wire:ignore multiple>
        <button>Submit</button>
    </form>
</div>
