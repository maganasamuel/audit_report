<?php

namespace App\Http\Livewire\UserProfile;

use App\Actions\UserProfile\UpdatePassword;
use Livewire\Component;

class Password extends Component
{
    public $input = [];

    public function render()
    {
        return view('livewire.user-profile.password');
    }

    public function updateUserPassword(UpdatePassword $action)
    {
        $action->update($this->input);

        $this->dispatchBrowserEvent('user-password-updated', 'User password has been updated.');

        $this->input = [];
    }
}
