<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search;

    public $sortColumn = [
        'name' => 'policy_holder',
        'direction' => 'asc',
    ];

    public $client;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $query = Client::when($this->search, function ($query) {
            return $query->where('policy_holder', 'like', '%' . $this->search . '%')
                ->orWhere('policy_no', 'like', '%' . $this->search . '%');
        });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        }

        $clients = $query->paginate($this->perPage);

        return view('livewire.clients.index', compact('clients'));
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        $sortDirections = [
            '' => 'asc',
            'asc' => 'desc',
            'desc' => '',
        ];

        if ($this->sortColumn['name'] == $column) {
            $this->sortColumn['direction'] = $sortDirections[$this->sortColumn['direction']];
        } else {
            $this->sortColumn['name'] = $column;
            $this->sortColumn['direction'] = 'asc';
        }
    }

    public function deleteClient(Client $client)
    {
        $this->client = $client;

        $this->canDeleteClient();
    }

    public function confirmDelete()
    {
        if (! $this->canDeleteClient()) {
            return false;
        }

        $this->client->delete();

        $this->emit('clientDeleted', 'Successfully deleted client.');
    }

    public function canDeleteClient()
    {
        Session::forget('cannotDelete');

        if ($this->client->audits()->count()) {
            Session::put('cannotDelete', 'Cannot delete client. Please make sure that there are no client feedbacks with this client.');

            return false;
        }

        if ($this->client->surveys()->count()) {
            Session::put('cannotDelete', 'Cannot delete client. Please make sure that there are no surveys with this client.');

            return false;
        }

        return true;
    }
}
