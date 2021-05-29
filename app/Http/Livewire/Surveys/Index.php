<?php

namespace App\Http\Livewire\Surveys;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $client;

    public $perPage = 10;

    public $search;

    public $sortColumn = [
        'name' => '',
        'direction' => '',
    ];

    public $survey;

    protected $paginationTheme = 'bootstrap';

    public function mount($client)
    {
        $this->client = $client;
    }

    public function render()
    {
        $query = $this->client->surveys()->when($this->search, function ($query) {
            return $query->where();
        });

        $surveys = $query->paginate($this->perPage);

        return view('livewire.surveys.index', compact('surveys'));
    }
}
