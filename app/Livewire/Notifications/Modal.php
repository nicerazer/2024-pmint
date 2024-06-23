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
    public bool $firstLoad = false;

    public array $unreadNotifs;
    public array $readNotifs;
    public array $allNotifs;

    public function mount() {
        $this->notifs = $this->notifsQuery(true)->get();
    }

    public function render()
    {
        return view('livewire.notifications.modal');
    }

    public function notifsQuery(bool $onlyUnread = false) {
        if ($onlyUnread)
            return auth()->user()->unreadNotifications()->limit($this->pageSize)->offset($this->pageSize * ($this->page - 1));
        return auth()->user()->notifications()->limit($this->pageSize)->offset($this->pageSize * ($this->page - 1));
    }

    public function resetNotifs(bool $onlyUnread = false) {
        $this->page = 1;
        $this->notifs = $this->notifsQuery($onlyUnread)->get();

        Log::debug('Notifs resetting ');
        Log::debug($this->notifs->count());
        return $this->notifs->all();

    }

    public function loadMoreNotifs(int $page, bool $onlyUnread = false) : array {
        $this->notifs = $this->notifsQuery($onlyUnread)->get();

        if (!$this->firstLoad && $this->loadable) {
            ++$page;
            $res = $this->notifsQuery($onlyUnread)->get();
            if ($res->isNotEmpty())
                $this->notifs->merge($res);
            elseif ($res->isEmpty())
                $this->loadable = false;
        }

        $this->firstLoad = true;

        Log::debug('Notifs loading more ');
        Log::debug($this->notifs->count());

        return [
            'loadable' => $this->loadable,
            'notifs' => $this->notifs->all(),
            'page' => $this->page,
        ];
    }

}
