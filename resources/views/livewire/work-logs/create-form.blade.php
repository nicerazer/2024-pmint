@php
    use App\Helpers\WorkLogCodes;
    use App\Models\Workscope;

@endphp

<form wire:submit="save" class="flex flex-col gap-4" x-data="{ isSubmit: false }">

    <div class="flex gap-8"> <!-- Activity Section -->
        <div class="w-[30rem]">
            <label class="block mb-3 text-lg font-semibold">Unit</label>
            <div class="form-control">
                <select class="w-full select select-bordered @error('form.staffUnit') select-error @enderror"
                    wire:change="switchUnit($event.target.value)" wire:model="form.staffUnit">
                    <option disabled selected value="-1">Pilih Unit</option>
                    @foreach ($staffUnits as $staff_unit)
                        <option wire:key="{{ $staff_unit->id }}" value="{{ $staff_unit->id }}">{{ $staff_unit->name }}
                        </option>
                    @endforeach
                </select>
                <div class="label">
                    @error('form.staffUnit')
                        <span class="text-error label-text-alt">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="w-full">
            <label class="block mb-3 text-lg font-semibold">Aktiviti</label>
            @if ($selectedUnitId != -1)

                <div class="form-control">
                    <div class="w-full join" wire:loading.delay.class="hidden" wire:target="switchUnit"
                        x-data="{ activityType: 'main' }">
                        <select class="w-60 select select-bordered join-item" wire:model="form.activityType"
                            x-on:change="activityType = $event.target.value">
                            <option disabled>Jenis Aktiviti</option>
                            <option value="main" selected>Aktiviti Utama</option>
                            <option value="alternative">Aktiviti Sampingan</option>
                        </select>
                        <select
                            class="w-full rounded-r-full select select-bordered @error('form.workScopeMainId') select-error @enderror"
                            wire:model="form.workScopeMainId" x-show="activityType == 'main'" required>
                            <option disabled selected value="-1">Pilih Aktiviti</option>
                            @foreach ($work_scopes as $work_scope)
                                <option wire:key="{{ $work_scope->id }}" value="{{ $work_scope->id }}">
                                    {{ $work_scope->title }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" class="w-full rounded-r-full input input-bordered"
                            x-show="activityType == 'alternative'" placeholder="Isi aktiviti sampingan"
                            wire:model="form.workAlternative">
                    </div>
                    <div class="label">
                        @error('form.workScopeMainId')
                            <span class="text-error label-text-alt ml-52">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="hidden w-full border border-gray-300 join" wire:loading.remove.delay.class="hidden"
                    wire:target="switchUnit">
                    <div class="flex items-center justify-center w-full h-12 gap-2 pl-4 skeleton join-item">
                        Memuat turun data <span class="loading loading-spinner loading-xs"></span>
                    </div>
                </div>
            @else
                <div class="w-full border border-gray-300 join">
                    <div class="flex items-center justify-center w-full h-12 gap-2 pl-4 bg-gray-200 join-item">
                        👈 Sila pilih unit
                    </div>
                </div>
            @endif
        </div>
    </div> <!-- Activity Section -->

    <div> <!-- Description Section -->
        <label for="" class="block mb-1 text-lg font-semibold">Nota Aktiviti</label>
        <textarea class="w-full textarea textarea-bordered" placeholder="" rows="2" wire:model="form.workNotes"></textarea>
    </div> <!-- Description Section -->

    <div class="flex gap-4"> <!-- Activity and Dates Section -->
        <div class="w-[30rem]">
            <label class="block mb-3 text-lg font-semibold">Status Aktiviti</label>
            <select class="w-full select select-bordered"
                @change="isSubmit = $event.target.value == {{ WorkLogCodes::SUBMITTED }}" wire:model="form.workStatus">
                <option disabled>Pilih Status</option>
                <option value="{{ WorkLogCodes::ONGOING }}" selected>Dalam Tindakan</option>
                <option value="{{ WorkLogCodes::SUBMITTED }}">Penghantaran</option>
                {{-- <option value="{{ WorkLogCodes::CLOSED }}">Dibatalkan</option> --}}
            </select>
        </div>
        <div class="w-full">
            <div class="flex">
                <div class="flex-1 w-full">
                    <label class="block mb-3 text-lg font-semibold">Tarikh Mula</label>
                </div>
                <div class="flex-1 w-full">
                    <label class="block mb-3 text-lg font-semibold"
                        x-text="isSubmit ? 'Tarikh Akhir' : 'Jangka Siap'">Tarikh Akhir</label>
                </div>
            </div>
            <div class="w-full join">
                <input type="date" class="w-full input input-bordered join-item" wire:model="form.started_at"
                    required />
                <input type="date" class="w-full input input-bordered join-item"
                    wire:model="form.expected_submitted_at" required />
            </div>
        </div>
    </div> <!-- Activity and Dates Section -->

    <div x-show="isSubmit">

        <div class="mb-3"> <!-- Description Section -->
            <label for="submission_notes" class="block mb-3 text-lg font-semibold">Nota Penghantaran</label>
            <textarea class="w-full textarea textarea-bordered" placeholder="Nota penghantaran" rows="5"
                name="submission_notes" id="submission_notes"></textarea>
        </div> <!-- Description Section -->
        <h2 class="block mb-3 text-lg font-semibold">Sertakan bahan bukti di bawah</h2>
        <div class="flex w-full gap-8" wire:ignore>
            <x-input.filepond wire:model="form.attachments" multiple allowImagePreview imagePreviewMaxHeight="200"
                allowFileTypeValidation
                acceptedFileTypes="[
                    'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
                    'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/rtf', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/gzip', 'application/pdf', 'application/vnd.rar', 'application/zip', 'application/x-7z-compressed'
                ]"
                allowFileSizeValidation maxFileSize="100mb" />
            @error('form.attachments')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    <button type="submit" class="self-center px-40 mt-8 text-2xl text-white btn btn-primary btn-lg">Mula
        Aktiviti</button>

</form>

{{-- @push('scripts')
    <script type="module">
        // Get a reference to the file input element
        const imageUploadElement = document.getElementById('image-uploads');
        // const documentUploadElement = document.querySelector('#document-uploads');

        // FilePond.setOptions({
        //     // server: {
        //     // url: '/temporary-uploads'
        //     // process: {
        //     headers: {
        //         'x-custom-header': 'Hello World',
        //     },
        //     //     },
        //     // },
        // });
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // const headers = {
        //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content']
        // };

        // Create a FilePond instance
        const pondImages = FilePond.create(imageUploadElement, {
            allowMultiple: true,
            server: {
                url: '/temporary-uploads',
                // process: '/temporary-uploads',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            },
            labelIdle: 'Pilih <span class="font-bold">gambar</span> untuk dimuat naik',
            imageValidateSizeMaxWidth: 10000,
            imageValidateSizeMaxHeight: 10000,
            maxFileSize: 10000000,
            acceptedFileTypes: 'image/*',
            imagePreviewHeight: '100'
        });

        // const pondDocuments = FilePond.create(documentUploadElement, {
        //     allowMultiple: true,
        //     headers: headers,
        //     // server: 'workLogs/1/documents',
        //     labelIdle: 'Pilih <span class="font-bold">dokumen</span> untuk dimuat naik',
        //     maxFileSize: 50000000,
        //     acceptedFileTypes: [
        //         'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        //         'application/x-7z-compressed', 'application/vnd.rar',
        //         'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        //         'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword',
        //         'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        //     ],
        // });
    </script>
@endpush --}}
