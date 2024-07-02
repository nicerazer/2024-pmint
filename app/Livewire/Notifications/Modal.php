<?php

namespace App\Livewire\Notifications;

use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modal extends Component
{
    public DatabaseNotificationCollection $notifs;
    public int $page = 1;
    private int $pageSize = 8;
    public bool $loadable = true;
    public bool $firstLoad = true;

    public function mount() {
        $this->notifs = $this->notifsQuery(true)->get();
    }

    public function render()
    {
        return view('livewire.notifications.modal');
    }

    public function notifsQuery(bool $onlyUnread) {
        if ($onlyUnread)
            return auth()->user()->unreadNotifications()->limit($this->pageSize)->offset($this->pageSize * ($this->page - 1));
        return auth()->user()->notifications()->limit($this->pageSize)->offset($this->pageSize * ($this->page - 1));
    }

    public function resetNotifs(bool $onlyUnread) {
        Log::debug('Notifs resetting: Init');
        $this->page = 1;
        Log::debug('Notifs resetting: Page #'. $this->page);
        $this->notifs = $this->notifsQuery($onlyUnread)->get();
        Log::debug('Notifs resetting: Loaded notifs count #'. $this->notifs->count());

        $isRead = $onlyUnread ? 'unread' : 'all';
        Log::debug('Notifs resetting: Mode #' . $isRead);
        return $this->notifs->all();
    }

    public function loadMoreNotifs(int $page, bool $onlyUnread) : array {
        Log::debug('Notifs loading: Init.');
        $this->notifs = $this->notifsQuery($onlyUnread)->get();

        if (!$this->firstLoad && $this->loadable) {
            ++$page;
            $res = $this->notifsQuery($onlyUnread)->get();
            if ($res->isNotEmpty()) {
                Log::debug('Notifs loading: Still can load, loading.');
                $this->notifs->merge($res);
            }
            elseif ($res->isEmpty()) {
                Log::debug('Notifs loading: Closing load method.');
                $this->loadable = false;
            }
        } else {
            Log::debug('Notifs loading: Load method was closed.');
        }

        if ($this->firstLoad) {
            Log::debug('Notifs loading: Marking as first load.');
            $this->firstLoad = false;
        }

        return [
            'loadable' => $this->loadable,
            'page' => $this->page,
        ];
    }

}
