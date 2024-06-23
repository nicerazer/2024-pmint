<!-- You can open the modal using ID.showModal() method -->
<dialog id="notifModal" class="modal" wire:ignore>
    <div class="modal-box" x-data="{
        notifs: {{ Js::from($this->notifs->all()) }},
        selectedNotifType: 'unread',
        page: 1,
        loadable: true,

        switchNotifs(notifType) {
            this.notifs = $wire.resetNotifs(notifType == 'unread')
            this.selectedNotifType = notifType;
            this.loadable = true
            this.page = 1;
            console.log('refreshing ' + notifType + ' data');
        },

        loadMoreNotifs(notifType) {
            if (! this.loadable) {
                console.log('Nothing more could be loadaed and no server trip made. Page :' + this.page);
                return null
            }

            const data = $wire.loadMoreNotifs(this.page, this.selectedNotifsType == 'unread');
            if (data.loadable) {
                this.notifs = data.notifs;
                this.page = data.page;
                console.log('Loading more for ' + ' at ' + this.page);
            } else {
                this.loadable = data.loadable;
                console.log('Page is reached the end. Page is at :' + this.page);
            }

            console.log(this.notifs.length)
        },
    }">
        <form method="dialog">
            <button class="absolute btn btn-sm btn-circle btn-ghost right-4 top-4">✕</button>
        </form>
        <h3 class="mb-2 text-lg font-bold">Notifikasi</h3>
        {{-- <p class="py-4">Press ESC key or click on ✕ button to close</p> --}}
        {{-- <div class="card-body"> --}}

            <div class="flex justify-between">
                <div role="tablist" class="tabs tabs-bordered">
                    <a role="tab" class="tab" :class="{ 'tab-active' : selectedNotifType == 'unread'}" @click="switchNotifs('unread')">Terbaru <div class="ml-2 badge badge-sm badge-secondary">2</div></a>
                    <a role="tab" class="tab" :class="{ 'tab-active' : selectedNotifType == 'all'}" @click="switchNotifs('all')">Semua</a>
                </div>
                {{-- <h4 class="font-semibold text-gray-600 hover:text-gray-700">
                    <span>Notifikasi</span>

                </h4> --}}
                <button class="link link-secondary link-hover">Set baca semua</button>
            </div>
            <div class="flex flex-col gap-2 border-b max-h-[25rem] h-[25rem] overflow-y-auto overflow-x-hidden">
                <template x-for="notif in notifs">
                    <x-notifications.item />
                </template>
                {{-- <div class="flex gap-3 px-2 py-2 -mx-2 rounded-lg hover:bg-gray-200">
                    <!-- Worklog past due -->
                    <div class="relative flex items-center justify-center w-12 h-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-ping size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <!-- Notification Content -->
                    <div>
                        <h3 class="mb-2"><a href="" class="link link-hover">Log kerja anda</a> <span class="text-gray-400">melebihi jangka waktu.</span></h3>
                        <div class="text-sm text-gray-400">
                            <span>Jangka siap </span>
                            <span class="inline-block w-1 h-1 mx-1 mb-0.5 bg-gray-400 rounded-full"></span>
                            <span> 1 Jun 2024</span>
                        </div>
                    </div>
                </div> --}}
                <div class="h-40" x-intersect="loadMoreNotifs(selectedNotifType)"></div>
            </div>
            <div class="flex flex-row items-center justify-between w-full mt-2">
                {{-- <span>5 belum dibaca</span> --}}
                {{-- <button class="link link-hover link-neutral" onclick="notifModal.showModal()">
                    Buka lagi
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-1 mb-0.5 inline size-5">
                        <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
                        </svg>
                </button> --}}
            </div>
        {{-- </div> --}}

    </div>
</dialog>
