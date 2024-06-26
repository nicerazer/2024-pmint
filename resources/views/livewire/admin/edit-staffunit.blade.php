<div class="card-body">
    <h2 class="font-bold text-gray-600 card-title"><span class="text-gray-500">Kemaskini Unit </span>
        <span wire:loading class="loading loading-spinner loading-sm"></span>
        @if ($staff_unit)
            <span wire:loading.class='animate-pulse'>{{ $name }}</span>
        @endif
    </h2>
    @if ($staff_unit)
        <form wire:submit="save">
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Nama Unit</span>
                </div>
                <input type="text" placeholder="Isi nama unit" class="w-full input input-bordered" wire:model="name"
                    value="{{ $name }}">
                @error('name')
                    <div class="label">
                        {{-- <span class="label-text-alt">{{ $message }}</span> --}}
                        <span class="text-error label-text-alt">Sila isi ruang ini</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Bahagian</span>
                </div>

                <select class="w-full select select-bordered" wire:model="staff_section_id">
                    <option disabled value="0">Pilih Bahagian</option>
                    @foreach (App\Models\StaffSection::all() as $staff_section)
                        <option wire:key="{{ $staff_section->id }}" value="{{ $staff_section->id }}">{{ $staff_section->name }}</option>
                    @endforeach
                </select>

                @error('staff_section_id')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>

            <!-- ACTION: Save the model -->
            <div class="justify-end mt-4 card-actions">
                <button type="submit" class="w-60 btn btn-primary">Kemaskini
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-mt-0.5 size-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>


        <div class="divider"></div>

        <div class="flex justify-between w-full mb-3">
            <h3 class="mb-2 text-xl font-bold">Buang unit</h3>
            <p class="flex-grow-0 text-gray-700"><span class="font-bold">Staff, log kerja</span> berkaitan dengan unit ini akan dibuang.</p>
        </div>

        <button class="ml-auto btn btn-error w-60" onclick="delete_unit_modal.showModal()">
            Buang Unit
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-mt-0.5 size-5">
                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Open the modal using ID.showModal() method -->
        <dialog id="delete_unit_modal" class="modal" wire:ignore.self>
            <div class="modal-box">
                <div class="flex items-center justify-center w-12 h-12 mx-auto text-red-500 border border-red-100 rounded bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="mt-3 mb-1 text-lg font-bold text-center">Buang unit?</h3>
                <p class="mb-3 text-center text-gray-700">Isi kata laluan</p>
                <div class="flex justify-center">
                    <label class="form-control w-96">
                        <input wire:model='delete_confirm_pass' type="password" class="input input-bordered" placeholder="Kata Laluan">
                        <div class="justify-center label">
                            @if ($delete_confirm_pass_unmatched)
                                <span class="label-text text-error">Kata laluan salah</span>
                            @endif
                        </div>
                    </label>
                </div>
                <div class="flex items-center justify-center gap-2 modal-action">
                    <form method="dialog">
                        <!-- if there is a button in form, it will close the modal -->
                        <button class="btn">Batal</button>
                    </form>
                    <button wire:click='delete' class="btn btn-error">Buang Unit</button>
                </div>
            </div>
        </dialog>
    @else
        Sila pilih unit
    @endif
</div>
