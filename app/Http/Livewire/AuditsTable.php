<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class AuditsTable extends Component
{

    use WithPagination;

	public $perPage = 10;

	public $search;

	public $sortField = 'pdf_title';

	public $sortAsc = true;

    public $client;

    public function mount($client)
    {
        $this->client = $client;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

   public function sortBy($field)
	{

        $this->sortAsc === $field ? $this->sortAsc = !$this->sortAsc : $this->sortField = $field;
	}


    public function render()
    {
        $this->search = strtolower($this->search);
        
    	$audits = $this->client->audits()
            ->whereRaw('lower(pdf_title) like (?)',["%{$this->search}%"])
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.audits-table',[

            'audits' => $audits->paginate($this->perPage)
        ]);
    }
}
