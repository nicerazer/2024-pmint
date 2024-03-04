<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    // #[Validate('image|max:1024')]
    public $newAvatar;

    public function render()
    {
        return view('livewire.edit-profile');
    }

    public function uploadAvatar()
    {
        Auth::user()->addMedia($this->newAvatar)->toMediaCollection('avatar');

        session()->flash('status-class', 'success');
        session()->flash('message', 'Gambar selesai dimuat naik.');

        return $this->redirectRoute('profile.edit');
    }
}
