@php
    use App\Helpers\WorkLogHelper;
    use App\Models\Workscope;
@endphp

<form wire:submit="save">
    <div class="flex flex-col gap-12 mt-12">
        <div class="flex w-full gap-8">
            <div class="w-80">
                <h4 class="mb-2 font-bold w-80">Skop Kerja</h4>
                <p class="text-gray-600 w-80">Pilih Kerja yang berkaitan dengan bahagian anda</p>
            </div>
            <div class="w-full grow">
                <select class="w-full border-gray-300 select " wire:model="work_scope_id">
                    <option disabled selected value="">Pilih kerja</option>
                    @foreach (WorkScope::all() as $workScope)
                        <option value="{{ $workScope->id }}">{{ $workScope->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="flex w-full gap-8">
            <div class="w-80">
                <h4 class="mb-2 font-bold w-80">Masa</h4>
                <p class="text-gray-600 w-80">Isi jangka masa tamat kerja</p>
            </div>
            <div class="w-full grow">
                <div class="w-full"> <!-- Masa kerja-->
                    <h4 class="mb-2">Tempoh Kerja</h4>
                    <div class="flex items-end gap-4 mb-1">
                        <div wire:poll class="w-full max-w-xs form-control">
                            <label class="label">
                                <span class="label-text">Mula</span>
                            </label>
                            <input type="time" value="{{ now()->second(0)->toTimeString() }}"
                                class="w-full input input-bordered" disabled />
                        </div>
                        <div class="w-full max-w-xs form-control">
                            {{-- <label class="label">
                                    <span class="label-text">Tarikh</span>
                                </label> --}}
                            <input type="date" value="{{ now()->toDateString() }}"
                                class="w-full input input-bordered" disabled />
                        </div>
                    </div>
                    <div class="flex items-end gap-4">
                        <div wire:poll class="w-full max-w-xs form-control">
                            <label class="label">
                                <span class="label-text">Akhir</span>
                            </label>
                            <input wire:model="end_time" type="time" class="w-full input input-bordered" />
                        </div>
                        <div class="w-full max-w-xs form-control">
                            {{-- <label class="label">
                                    <span class="label-text">Habis</span>
                                </label> --}}
                            <input wire:model="end_date" type="date" class="w-full input input-bordered" />
                        </div>
                    </div>
                </div> <!-- Masa kerja-->
            </div>
        </div>

    </div>

    <hr class="mt-16 mb-12">

    <div class="flex w-full gap-8">
        <div class="w-80">
            <h4 class="mb-2 font-bold w-80">Keterangan</h4>
            <p class="text-gray-600 w-80">Isi keterangan kerja anda (optional)</p>
        </div>
        <div class="w-full grow">
            <div class="w-full">
                <textarea wire:model="description" placeholder="Keterangan..." class="w-full textarea textarea-bordered" rows="5"></textarea>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end w-full gap-8 mt-20">
        <button type="submit" class="text-white btn btn-primary">Mula Kerja</button>
    </div>

</form>
