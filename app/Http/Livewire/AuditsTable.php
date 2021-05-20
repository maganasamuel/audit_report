<?php

namespace App\Http\Livewire;

use App\Models\Audit;
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

    public $updateMode = false;

    public $audit;

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


    public function onEdit(Audit $audit)
    {   
        $this->audit = $audit;

        $this->updateMode = true;

        $this->emit('auditClicked', $audit->id);
    }

    public function onDelete(Audit $audit)
    {
        $this->audit = $audit;
    }


    public function confirmDelete()
    {
        $this->audit->delete();

        session()->flash('message', 'Successfully deleted audit.');

        $this->emit('onConfirmDelete');
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
