<div class="flex gap-2 px-2 py-2 -mx-2 rounded-lg hover:bg-gray-200">
    @if ($notif->type == 'App\Notifications\RolesModifiedOnAUser')
        <!-- Roles Modified Icons -->
        <div class="relative flex items-center justify-center w-10 h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
            </svg>
        </div>
        <!-- Roles Modified Content -->
        <div>
            <h3 class="mb-2">Mod kerja dikemaskini oleh admin</h3>
            <div class="flex flex-wrap gap-1.5 mb-1">
                @foreach ($notif->data['new_roles'] as $role_name)
                    <div class="badge badge-neutral badge-xs">{{ $role_name }}</div>
                @endforeach
            </div>
            <div class="text-sm text-gray-400">
                <span>Dikemaskini pada </span>
                <span class="inline-block w-1 h-1 mx-1 mb-0.5 bg-gray-400 rounded-full"></span>
                <span> {{ (new Carbon\Carbon($notif->data['edited_at']))->locale('ms')->diffForHumans() }}</span>
            </div>
        </div>

    @elseif ($notif->type == 'App\Notifications\WorkLogPastDue')
        <!-- WL Past Due Icons -->
        <div class="relative flex items-center justify-center w-10 h-12">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-ping size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg> --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <!-- WL Past Due Content -->
        <div>
            <h3 class="mb-2"><a href="/logkerja/{{ $notif->data['worklog_id'] }}" class="link link-hover">Log kerja anda</a> <span class="text-gray-400">melebihi jangka waktu.</span></h3>
            <div class="text-sm text-gray-400">
                <span>Jangka siap </span>
                <span class="inline-block w-1 h-1 mx-1 mb-0.5 bg-gray-400 rounded-full"></span>
                <span> {{ (new Carbon\Carbon($notif->data['expected_at']))->locale('ms')->diffForHumans() }}</span>
            </div>
        </div>
        @elseif (
            $notif->type == 'App\Notifications\SubmissionAccepted' ||
            $notif->type == 'App\Notifications\SubmissionRejected'
        )
            @php
                $user = App\Models\User::find($notif->data['evaluator_id']);
                $isAccept = $notif->type == 'App\Notifications\SubmissionAccepted';
            @endphp
            <div class="relative flex items-center justify-center flex-shrink-0 w-10 h-12">
                @if ($user && $user->getFirstMediaUrl('avatar'))
                    <img class="object-contain bg-white border rounded-full size-10" alt="No image" src="{{ $user->getFirstMediaUrl('avatar') }}">
                @else
                    <img class="size-10" alt="No image" src="{{ asset('assets/placeholders/anonymous.png') }}">
                @endif
                {{-- @if($isAccept)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                @endif --}}
            </div>
            <div>
                <h3 class="mb-2">
                    <a href="/logkerja/{{ $notif->data['worklog_id'] }}" class="link link-hover">Log kerja anda</a>
                    <span class="@if($isAccept) text-success @else text-error @endif"> {{ $isAccept ? 'disahkan oleh' : 'dikembali oleh' }} </span>
                    <span class="text-gray-400"> {{ $user ? $user->name : $notif->data['evaluator_name'] }}.</span>
                </h3>
                <div class="text-sm text-gray-400">
                    <span>Disemak pada </span>
                    <span class="inline-block w-1 h-1 mx-1 mb-0.5 bg-gray-400 rounded-full"></span>
                    <span> {{ (new Carbon\Carbon($notif->data['evaluated_at']))->locale('ms')->diffForHumans() }}</span>
                </div>
            </div>
        @endif
</div>
