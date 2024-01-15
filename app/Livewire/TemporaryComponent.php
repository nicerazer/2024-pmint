<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class TemporaryComponent extends Component
{
    public $worklogs;
    #[Reactive]
    public $status_index;

    // public function mount($worklogs)
    // {
    //     $this->worklogs = $worklogs;
    // }


    public function render()
    {
        // dd ($this->worklogs);
        return view('livewire.temporary-component', [
            'worklogs' => $this->worklogs,
            'status_index' => $this->status_index,
        ]);
    }
}
