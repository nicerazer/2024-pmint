<div class="relative flex flex-col gap-8 basis-7/12">
    {{-- Right Side : Submissions --}}
    {{-- <button type="button" wire:click="submitt">{{ $submitting ? 'yay' : 'aww' }}</button> --}}
    {{-- @if ($submitting) --}}
    {{-- @endif --}}
    @if (
        (auth()->user()->isStaff() && $worklog->submitable()) ||
            (auth()->user()->isEvaluator1() && $worklog->evaluatable()))
        <div class="w-full bg-white shadow-lg card" x-show="true" x-transition>
            @if (auth()->user()->isStaff() && $worklog->submitable())
                <livewire:work-logs.show.submission-form :worklog="$worklog" />
            @endif
            @if (auth()->user()->isEvaluator1() && $worklog->evaluatable())
                <livewire:work-logs.show.evaluation-form :submission="$worklog->latestSubmission" />
            @endif
        </div>
    @endif
    <livewire:work-logs.show.submissions :$worklog />

    <div class="relative">
        {{-- @unless ($worklog->submitted_at && ($worklog->level_1_accepted_at || $worklog->level_2_accepted_at))
                @unless ($worklog->submitted_at)
                    <div class="w-full" x-show="selectedWindowTitle == 'editWorkLog'" x-transition>
                        <div class="flex mt-8">
                            <div class="w-52">
                                <h4 class="w-52">Skop Kerja</h4>
                            </div>
                            @if (false)
                                <div class="grow">
                                    <select class="w-full border-gray-300 select " wire:model="work_scope_id">
                                        <option disabled selected value="">Pilih kerja</option>
                                        @foreach (WorkScope::all() as $workScope)
                                            <option value="{{ $workScope->id }}"
                                                @if ($worklog->workscope->id == $workScope->id) selected @endif>
                                                {{ $workScope->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="flex mt-8">
                            <div class="w-52">
                                <h4 class="w-52">Status</h4>
                            </div>
                            <div>
                                <h5>
                                    <x-work-logs.status-badge :$worklog />
                                </h5>
                            </div>
                        </div>
                        <div class="flex mt-8">
                            <div class="w-52">
                                <h4 class="w-52">Penilaian</h4>
                            </div>
                            <div>
                                <h5>{{ $worklog->rating }}</h5>
                            </div>
                        </div>
                        <div class="flex mt-8">
                            <div class="w-52">
                                <h4 class="w-52">Nota</h4>
                            </div>
                            <div class="grow">
                                <textarea wire:model="description" placeholder="Keterangan..." class="w-full textarea textarea-bordered" rows="5">{{ $worklog->description }}</textarea>
                            </div>
                        </div>
                    </div>
                @endunless

            @endunless --}}
    </div>

</div> {{-- Right Side : Submissions --}}
