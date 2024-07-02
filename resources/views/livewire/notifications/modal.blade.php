<!-- You can open the modal using ID.showModal() method -->
<dialog id="notifModal" class="modal" wire:ignore.self>
    <div wire:ignore.self class="modal-box" x-data="{
        selectedNotifType: 'unread',
        page: 1,
        loadable: true,

        switchNotifs(notifType) {
            $wire.resetNotifs(notifType == 'unread');
            this.selectedNotifType = notifType;
            this.loadable = true;
            this.page = 1;
            console.log('refreshing ' + notifType + ' data');
        },

        loadMoreNotifs() {
            if (! this.loadable) {
                console.log('Nothing more could be loadaed and no server trip made. Page :' + this.page);
                return null;
            }

            const data = $wire.loadMoreNotifs(this.page, this.selectedNotifType == 'unread');
            if (data.loadable) {
                this.page = data.page;
                console.log('Loading more for ' + ' at ' + this.page);
            } else {
                this.loadable = data.loadable;
                console.log('Page has reached the end. Page is at :' + this.page);
            }
        },
    }">
        <form method="dialog" wire:ignore.self>
            <button class="absolute btn btn-sm btn-circle btn-ghost right-4 top-4">✕</button>
        </form>
        <h3 class="mb-2 text-lg font-bold">Notifikasi</h3>
        <div class="flex justify-between">
            <div role="tablist" class="tabs tabs-bordered" wire:ignore>
                <a role="tab" class="tab" :class="{ 'tab-active' : selectedNotifType == 'unread'}" @click="switchNotifs('unread')">
                    <span>Terbaru</span>
                    @php
                        $notifCounts = auth()->user()->unreadNotifications()->count();
                    @endphp
                    @if ($notifCounts)
                        <div class="ml-2 badge badge-sm badge-secondary">{{$notifCounts}}</div>
                    @endif
                </a>
                <a role="tab" class="tab" :class="{ 'tab-active' : selectedNotifType == 'all'}" @click="switchNotifs('all')">Semua</a>
            </div>

            <button class="link link-secondary link-hover">Set baca semua</button>
        </div>
        <div class="flex flex-col gap-2 border-b max-h-[25rem] h-[25rem] overflow-y-auto overflow-x-hidden mt-1">
            @forelse ($notifs as $notif)
                <x-notifications.item :notif="$notif" wire:key="{{ $notif->id }}" />
            @empty
                <div class="self-center w-40 mt-20">
                    <h3 class="text-lg font-medium text-center text-gray-500">Tiada notifikasi terbaru...</h3>
                    <img src="{{ asset('assets/empty/5-empty.png') }}" alt="Notification empty art">
                </div>
            @endforelse
            <div class="h-40" x-intersect="loadMoreNotifs()"></div>
        </div>
    </div>
</dialog>
