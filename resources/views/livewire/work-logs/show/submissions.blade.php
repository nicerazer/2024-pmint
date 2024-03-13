<div class="flex flex-col gap-8">
    @foreach ($submissions as $submission)
        <div
            class="shadow-lg card
            @if ($submission->evaluated_at && $submission->is_accept) bg-[#e4ffe5]
            @elseif ($submission->evaluated_at && !$submission->is_accept)  bg-[#FFE6A7] text-black
            @else bg-white @endif">
            <div class="py-7 card-body">
                <!-- Submission number and status -->
                <div class="flex items-center justify-between w-full">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Penghantaran No {{ $loop->remaining + 1 }}
                        </h1>
                        @if (env('APP_DEBUG'))
                            <h3 class="text-sm text-gray-800">ID #{{ $submission->id }}</h3>
                        @endif
                    </div>
                    @if ($submission->evaluated_at)
                        @if ($submission->is_accept)
                            <span class="flex items-center gap-2 font-bold text-green-600">
                                DITERIMA
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <span class="flex items-center gap-2 font-bold">
                                DIKEMBALIKAN
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    @endif
                </div> <!-- Submission number and status -->
                <!-- Time stamps -->
                <div class="flex items-end justify-between w-full">
                    <p class="@if ($submission->evaluated_at && $submission->is_accept) text-green-700 @endif">Pada
                        {{ $submission->created_at->format('j F Y') }}</p>
                    @if ($submission->evaluated_at)
                        <p class="text-right @if ($submission->evaluated_at && $submission->is_accept) text-green-700 @endif">Pada
                            {{ $submission->evaluated_at }}</p>
                    @endif
                </div> <!-- Time stamps -->
                <div class="mb-1 divider"></div>
                <!-- Submission evaluation notes -->
                @if ($submission->evaluated_at && !$submission->is_accept)
                    <div class="bg-[#FFC34F] px-4 py-3 rounded-lg mb-3">
                        <h2 class="mb-2 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="inline w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            Komen dari {{ ucwords($submission->evaluator->name) }}
                        </h2>
                        <p>{{ $submission->evaluator_comment }}</p>
                    </div> <!-- Submission evaluation notes -->
                @endif

                <h3 class="font-bold @if ($submission->evaluated_at && $submission->is_accept) text-green-900 @endif">
                    Nota Penghantaran
                </h3>
                <p class="@if ($submission->evaluated_at && $submission->is_accept) text-green-800 @endif">
                    {{ $submission->body ?: 'Tiada Nota' }}
                </p>
                <div class="mb-1 divider"></div>
                <livewire:work-logs.show.images :$submission />
                <livewire:work-logs.show.documents :$submission />
            </div>
        </div>
    @endforeach
</div>
