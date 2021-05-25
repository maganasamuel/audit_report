<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
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

    public $sortClasses = [
        '' => 'fa-sort',
        'asc' => 'fa-sort-up',
        'desc' => 'fa-sort-down',
    ];

    public $client;

    public $updateMode = false;

    protected $paginationTheme = 'bootstrap';

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
        $query = Client::where('policy_holder', 'like', '%' . $this->search . '%')
            ->orWhere('policy_no', 'like', '%' . $this->search . '%');

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        }

        $clients = $query->paginate($this->perPage);

        return view('livewire.clients.index', compact('clients'));
    }
}
