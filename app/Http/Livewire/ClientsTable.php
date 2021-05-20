<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsTable extends Component
{

    use WithPagination;

	public $perPage = 10;

	public $search;

	public $sortField = 'policy_holder';

	public $sortAsc = true;

    public $client;

    public $updateMode = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
	{

        $this->sortAsc === $field ? $this->sortAsc = !$this->sortAsc : $this->sortField = $field;
	}

    public function onEdit(Client $client)
    {   
        $this->client = $client;

        $this->updateMode = true;

        $this->emit('clientClicked', $client->id);
    }

    public function onDelete(Client $client)
    {
        $this->client = $client;
    }


    public function confirmDelete()
    {
        $this->client->delete();

        session()->flash('message', 'Successfully deleted client.');

        $this->emit('onConfirmDelete');
    }


    public function render()
    {
        $this->search = strtolower($this->search);
        
    	$clients = Client::whereRaw('lower(policy_holder) like (?)',["%{$this->search}%"])
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.clients-table',[

            'clients' => $clients->paginate($this->perPage)
        ]);
    }
}
