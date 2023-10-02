<div class="flex items-center justify-end w-full gap-8 mt-20">
    <button class="text-white capitalize btn btn-primary" onclick="my_modal_3.showModal()">Semak</button>
    <form wire:submit="reject">
        <button type="submit" class="link link-error">Tolak</button>
    </form>

    <!-- You can open the modal using ID.showModal() method -->
    <dialog id="my_modal_3" class="modal">
        <div class="w-11/12 max-w-5xl modal-box">
            <form method="dialog">
                <button class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</button>
            </form>
            <form wire:submit="accept" id="evaluate">
                <h3 class="text-lg font-bold">Hello!</h3>
                <p class="py-4">Press ESC key or click on ✕ button to close</p>
                <div class="rating">
                    <input type="radio" name="rating-2" class="bg-orange-400 mask mask-star-2" />
                    <input type="radio" name="rating-2" class="bg-orange-400 mask mask-star-2" checked />
                    <input type="radio" name="rating-2" class="bg-orange-400 mask mask-star-2" />
                    <input type="radio" name="rating-2" class="bg-orange-400 mask mask-star-2" />
                    <input type="radio" name="rating-2" class="bg-orange-400 mask mask-star-2" />
                </div>
            </form>
            <div class="flex items-center justify-end gap-6">
                <button type="submit" form="evaluate" class="text-white capitalize btn btn-primary">Tanda Siap</button>
                <form method="dialog">
                    <button class="link">Batal</button>
                </form>
            </div>
        </div>
    </dialog>

</div>
