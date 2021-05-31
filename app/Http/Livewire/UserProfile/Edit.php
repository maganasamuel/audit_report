<?php

namespace App\Http\Livewire\UserProfile;

use App\Actions\UserProfile\UpdateInfo;
use Livewire\Component;

class Edit extends Component
{
    public $input;

    public function mount()
    {
        $this->input = auth()->user()->only(['name', 'email']);
    }

    public function render()
    {
        return view('livewire.user-profile.edit');
    }

    public function updateUserInfo(UpdateInfo $action)
    {
        $action->update($this->input);

        $this->dispatchBrowserEvent('user-info-updated', 'User information has been updated.');
    }
}
