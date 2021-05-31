<?php

namespace App\Http\Livewire\Clients;

use App\Actions\Clients\UpdateClient;
use App\Models\Client;
use Livewire\Component;

class Edit extends Component
{
    public $clientId;

    public $input = [];

    protected $listeners = ['editClient'];

    public function render()
    {
        return view('livewire.clients.edit');
    }

    public function editClient($clientId)
    {
        $this->clientId = $clientId;

        $this->input = collect(Client::findOrFail($this->clientId))->only([
            'policy_holder',
            'policy_no',
        ])->all();
    }

    public function updateClient(UpdateClient $action)
    {
        $action->update($this->input, Client::find($this->clientId));

        $this->emit('clientUpdated', 'Successfully updated Client.');
    }
}
