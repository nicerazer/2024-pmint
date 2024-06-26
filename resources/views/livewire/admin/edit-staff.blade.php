<div class="card-body">
    @php
        use App\Helpers\UserRoleCodes;
    @endphp

    <h2 class="font-bold text-gray-600 card-title"><span class="text-gray-500">Kemaskini Staf</span>
        <span wire:loading class="loading loading-spinner loading-sm"></span>
        @if ($staff)
            <span wire:loading.class='animate-pulse'>{{ $staff->name }}</span>
        @endif
    </h2>

    @if ($staff)

        <form wire:submit="save">
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Nama Staff</span>
                </div>
                <input wire:model="form.name" value="{{ $staff->name }}" type="text" placeholder="Isi nama unit"
                    class="w-full input input-bordered" wire:model="name" disabled />
                @error('form.name')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">E-mel</span>
                </div>
                <input wire:model="form.email" type="text" placeholder="Isi e-mel"
                    class="w-full input input-bordered" />
                @error('form.email')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">IC Staff</span>
                </div>
                <input wire:model="form.ic" type="text" placeholder="Isi nama unit"
                    class="w-full input input-bordered" />
                @error('form.ic')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Kata Laluan</span>
                </div>
                <input wire:model="form.password" type="password" placeholder="Tinggalkan jika tidak mahu ubah"
                    class="w-full input input-bordered" wire:model="password" />
                @error('form.password')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Pilih Bahagian</span>
                </div>
                <select wire:change="switchSection($event.target.value)" wire:model="form.selected_section_id"
                    class="w-full select select-bordered">
                    <option disabled selected value="-1">Pilih Bahagian</option>
                    @foreach (App\Models\StaffSection::all() as $staff_section)
                        <option wire:key="{{ $staff_section->id }}" value="{{ $staff_section->id }}">
                            {{ $staff_section->name }}</option>
                    @endforeach
                </select>
                @error('form.selected_section_id')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <label class="w-full mb-2 form-control">
                <div class="label">
                    <span class="label-text">Pilih Unit</span>
                </div>
                {{-- @if ($this->form->selected_section_id != 0 && $this->staffUnits->count() != 0) --}}
                @if ($this->form->selected_section_id != 0)
                    <select wire:model="form.selected_unit_id"
                        class="w-full select select-bordered">
                        <option disabled selected value="-1">Pilih Unit</option>
                        @foreach ($this->staff_units as $staff_unit)
                            <option wire:key="{{ $staff_unit->id }}" value="{{ $staff_unit->id }}">
                                {{ $staff_unit->name }}</option>
                        @endforeach
                    </select>
                @elseif ($this->staff_units->count() == 0)
                    <div class="w-full border border-gray-300 join">
                        <div class="flex items-center justify-center w-full h-12 gap-2 pl-4 bg-gray-200 join-item">
                            Tiada unit yang wujud
                        </div>
                    </div>
                @elseif ($this->form->selected_section_id == -1)
                    <div class="w-full border border-gray-300 join">
                        <div class="flex items-center justify-center w-full h-12 gap-2 pl-4 bg-gray-200 join-item">
                            👈 Sila pilih bahagian
                        </div>
                    </div>
                @else
                    NOINOISDNFSDF
                @endif
                {{-- Error Message --}}
                @error('form.selected_unit_id')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                @enderror
            </label>
            <h3 class="mt-4 mb-1 ml-1 font-bold">Role User</h3>
            <div class="w-fit">
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Admin</span>
                        <input wire:model="form.has_role_admin" value="yes" type="checkbox"
                            @if ($form->has_role_admin) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Penilai 1</span>
                        <input wire:model="form.has_role_evaluator_1" value="yes" type="checkbox"
                            @if ($form->has_role_evaluator_1) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Penilai 2</span>
                        <input wire:model="form.has_role_evaluator_2" value="yes" type="checkbox"
                            @if ($form->has_role_evaluator_2) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="mr-8 label-text">Staff</span>
                        <input wire:model="form.has_role_staff" value="yes" type="checkbox"
                            @if ($form->has_role_staff) checked="checked" @endif
                            class="checkbox checkbox-primary" />
                    </label>
                </div>
            </div>

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
            <h3 class="mb-2 text-xl font-bold">Buang staf</h3>
            <p class="flex-grow-0 text-gray-700"><span class="font-bold">Semua log kerja</span> berkaitan dengan staf ini akan dibuang.</p>
        </div>

        <button class="ml-auto btn btn-error w-60" onclick="delete_staff_modal.showModal()">
            Buang Staff
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-mt-0.5 size-5">
                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Open the modal using ID.showModal() method -->
        <dialog id="delete_staff_modal" class="modal" wire:ignore.self>
            <div class="modal-box">
                <div class="flex items-center justify-center w-12 h-12 mx-auto text-red-500 border border-red-100 rounded bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="mt-3 mb-1 text-lg font-bold text-center">Buang staff?</h3>
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
                    <button wire:click='delete' class="btn btn-error">Buang Staff</button>
                </div>
            </div>
        </dialog>


    @else
        Sedang ambil data dari sistem...
    @endif
    @foreach ($errors->all() as $message)
        {{ $message }}
    @endforeach
</div>
