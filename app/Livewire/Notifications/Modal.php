<?php

namespace App\Livewire\Notifications;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modal extends Component
{
    public Collection $notifs;
    public int $page = 1;
    private int $pageSize = 5;
    public bool $loadable = true;

    public array $unreadNotifs;
    public array $readNotifs;
    public array $allNotifs;

    public function mount() {
        $this->notifs = $this->notifsQuery()->get();
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
        return $this->notifs;

        Log::debug($this->notifs);

    }

    public function loadMoreNotifs(int $page, bool $onlyUnread = false) : array {
        if ($this->loadable) {
            ++$page;
            $res = $this->notifsQuery($onlyUnread)->get();
            if ($res->isNotEmpty())
                $this->notifs[] = $res;
            elseif ($res->isEmpty())
                $this->loadable = false;
        }

        Log::debug($this->notifs);

        return [
            'loadable' => $this->loadable,
            'notifs' => $this->notifs,
            'page' => $this->page,
        ];
    }

}
