@php
    use App\Helpers\WorkLogHelper;
    use App\Models\Workscope;
@endphp

<form wire:submit="save" class="flex flex-col gap-12">

    <div class="flex gap-8"> <!-- Activity Section -->
        <div class="w-[30rem]">
            <label class="block mb-3 text-lg font-semibold">Unit</label>
            <select class="w-full select select-bordered">
                <option disabled selected>Pilih Unit</option>
                <option>Latihan & Kualiti</option>
                <option>Perhubungan Korporat</option>
                <option>Pekhidmatan</option>
            </select>
        </div>
        <div class="w-full">
            <label class="block mb-3 text-lg font-semibold">Aktiviti</label>
            <div class="w-full join">
                <select class="select select-bordered join-item" name="activity-type">
                    <option disabled selected>Jenis Aktiviti</option>
                    <option value="main">Aktiviti Utama</option>
                    <option value="side">Aktiviti Sampingan</option>
                </select>

                <input class="w-full input input-bordered join-item" placeholder="Tajuk aktiviti" />
                {{-- <div class="w-full h-12 skeleton join-item"></div> --}}
            </div>

        </div>
    </div> <!-- Activity Section -->

    <div> <!-- Description Section -->
        <label for="" class="block mb-3 text-lg font-semibold">Nota Aktiviti</label>
        <textarea class="w-full textarea textarea-bordered" placeholder="" rows="5"></textarea>
    </div> <!-- Description Section -->

    <div class="divider"></div>

    <div class="flex gap-8"> <!-- Activity and Dates Section -->
        <div class="w-[30rem]">
            <label class="block mb-3 text-lg font-semibold">Status Aktiviti</label>
            <select class="w-full select select-bordered">
                <option disabled selected>Pilih Status</option>
                <option>Dalam Tindakan</option>
                <option>Penghantaran</option>
                <option>Dibatalkan</option>
            </select>
        </div>
        <div class="w-full">
            <div class="flex">
                <div class="flex-1 w-full">
                    <label class="block mb-3 text-lg font-semibold">Tarikh Mula</label>
                </div>
                <div class="flex-1 w-full">
                    <label class="block mb-3 text-lg font-semibold">Tarikh Akhir</label>
                </div>
            </div>
            <div class="w-full join">
                <input type="date" class="w-full input input-bordered join-item" />
                <input type="date" class="w-full input input-bordered join-item" />
            </div>
        </div>
    </div> <!-- Activity and Dates Section -->

    <div>
        <h2 class="block mb-3 text-lg font-semibold">Hantar Bahan Bukti</h2>
        <div class="flex w-full gap-8">
            <div class="w-full grow"><input name="document-upload" type="file" id="document-upload" /></div>
            <div class="w-full grow"><input name="image-upload" type="file" id="image-upload" /></div>
        </div>
    </div>

    <button type="submit" class="self-center px-40 mt-8 text-2xl text-white btn btn-primary btn-lg">Mula
        Aktiviti</button>

</form>

@push('scripts')
    <script type="module">
        // Get a reference to the file input element
        const imageUploadElement = document.getElementById('image-upload');
        const documentUploadElement = document.querySelector('#document-upload');

        // Create a FilePond instance
        const pondImages = FilePond.create(imageUploadElement, {
            allowMultiple: true,
            // server: 'workLogs/1/documents',
            labelIdle: 'Pilih <span class="font-bold">gambar</span> untuk dimuat naik',
            imageValidateSizeMaxWidth: 10000,
            imageValidateSizeMaxHeight: 10000,
            maxFileSize: 10000000,
            acceptedFileTypes: 'image/*',
            imagePreviewHeight: '100'
        });

        const pondDocuments = FilePond.create(documentUploadElement, {
            allowMultiple: true,
            // server: 'workLogs/1/documents',
            labelIdle: 'Pilih <span class="font-bold">dokumen</span> untuk dimuat naik',
            maxFileSize: 50000000,
            acceptedFileTypes: [
                'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/x-7z-compressed', 'application/vnd.rar',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
        });
    </script>
@endpush
