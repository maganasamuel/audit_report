<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class ClientForm extends Component
{
    public $client;

    public $policy_no;

    public $policy_holder;

    protected $listeners = ['clientClicked'];

    protected $rules = [

        'policy_holder' => 'required',
        'policy_no' => 'required'
    ];

    public function onSubmit()
    {
        $this->validate();

        $this->client ? $this->save() : $this->store();

    }

    public function store()
    {
        Client::create($this->validate());

        session()->flash('message', 'Successfully created Client.');
    }

    public function clientClicked(Client $client)
    {
        $this->client = $client;

        $this->policy_holder = $this->client->policy_holder;

        $this->policy_no = $this->client->policy_no;

    }

    /**
     * Will store client
     *
     * @return void
     */
    public function save()
    {

        $this->client->update([
            'policy_no' => $this->policy_no,
            'policy_holder' => $this->policy_holder

        ]);

        session()->flash('message', 'Successfully updated Client.');
        
        $this->emit('clientUpdate', $this->client);

    }

    public function render()
    {
        return view('livewire.client-form');
    }
}
