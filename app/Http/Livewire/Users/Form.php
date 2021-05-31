<?php

namespace App\Http\Livewire\Users;

use App\Actions\Users\CreateUser;
use App\Actions\Users\UpdateUser;
use App\Models\User;
use Livewire\Component;

class Form extends Component
{
    public $input;

    public $userId;

    protected $listeners = ['editUser'];

    public function getUserProperty()
    {
        return User::where('id', '!=', auth()->user()->id)->where('id', $this->userId)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.users.form');
    }

    public function resetInput()
    {
        $this->userId = null;

        $this->input = [];
    }

    public function editUser($userId)
    {
        $this->userId = $userId;

        $this->input = $this->user->only([
            'name',
            'email',
            'is_admin',
            'status',
        ]);
    }

    public function submit()
    {
        $this->userId ? $this->updateUser() : $this->createUser();
    }

    public function createUser()
    {
        $action = new CreateUser();

        $action->create($this->input);

        $this->dispatchBrowserEvent('user-created', 'User has been created.');
    }

    public function updateUser()
    {
        $action = new UpdateUser();

        $action->update($this->input, $this->user);

        $this->dispatchBrowserEvent('user-updated', 'User has been updated.');
    }
}
