<?php

namespace App\Http\Livewire\Audits;

use App\Jobs\MailAudit;
use App\Models\Audit;
use Illuminate\Support\Carbon;
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

    public $audit;

    protected $paginationTheme = 'bootstrap';

    public function mount($client)
    {
        $this->client = $client;
    }

    public function render()
    {
        $query = $this->client->audits()
            ->select(
                'audits.id',
                'adviser.name as adviser_name',
                'audits.lead_source',
                'audits.created_at',
                'creator.name as creator_name',
                'updator.name as updator_name'
            )->leftJoin('advisers as adviser', 'adviser.id', 'audits.adviser_id')
            ->leftJoin('users as creator', 'creator.id', 'audits.created_by')
            ->leftJoin('users as updator', 'updator.id', 'audits.updated_by')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('adviser.name', 'like', '%' . $this->search . '%')
                        ->orWhere('audits.lead_source', 'like', '%' . $this->search . '%')
                        ->when(strtotime($this->search), function ($query) {
                            $query->orWhereBetween('audits.created_at', [
                                Carbon::parse($this->search)->startOfDay()->toDateTimeString(),
                                Carbon::parse($this->search)->endOfDay()->toDateTimeString(),
                            ]);

                            return $query;
                        })->orWhere('creator.name', 'like', '%' . $this->search . '%')
                        ->orWhere('updator.name', 'like', '%' . $this->search . '%');
                });

                return $query;
            });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        }

        $audits = $query->paginate($this->perPage);

        return view('livewire.audits.index', compact('audits'));
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

    public function mailAudit(Audit $audit)
    {
        MailAudit::dispatch($audit);

        $this->dispatchBrowserEvent('audit-mailed', 'Successfully sent email to manager.');
    }

    public function confirmDeleteAudit(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function deleteAudit()
    {
        $this->audit->delete();

        session()->flash('message', 'Successfully deleted audit.');

        $this->emit('onConfirmDelete');
    }
}
