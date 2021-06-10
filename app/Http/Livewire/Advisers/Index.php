<?php

namespace App\Http\Livewire\Advisers;

use App\Models\Adviser;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search;

    public $sortColumn = [
        'name' => 'name',
        'direction' => 'asc',
    ];

    public $adviserId;

    public $badgeClass = [
        'Active' => 'badge bg-success text-white',
        'Terminated' => 'badge bg-danger text-white',
    ];

    protected $paginationTheme = 'bootstrap';

    public function getAdviserProperty()
    {
        return Adviser::findOrFail($this->adviserId);
    }

    public function render()
    {
        $searchColumns = [
            'name',
            'email',
            'fsp_no',
            'status',
        ];

        $query = Adviser::when($this->search, function ($query) use ($searchColumns) {
            foreach ($searchColumns as $column) {
                $query->orWhere($column, 'like', '%' . $this->search . '%');
            }

            return $query;
        });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        } else {
            $query->orderBy('id', 'desc');
        }

        $advisers = $query->paginate($this->perPage);

        return view('livewire.advisers.index', compact('advisers'));
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

    public function deleteAdviser($adviserId)
    {
        $this->adviserId = $adviserId;

        $this->canDeleteAdviser();
    }

    public function confirmDelete()
    {
        if (! $this->canDeleteAdviser()) {
            return false;
        }

        $this->adviser->delete();

        $this->dispatchBrowserEvent('adviser-deleted', 'Successfully deleted adviser.');
    }

    public function canDeleteAdviser()
    {
        Session::forget('cannotDelete');

        if ($this->adviser->audits()->count()) {
            Session::put('cannotDelete', 'Cannot delete adviser. Please make sure that there are no audits with this adviser.');

            return false;
        }

        if ($this->adviser->surveys()->count()) {
            Session::put('cannotDelete', 'Cannot delete adviser. Please make sure that there are no surveys with this adviser.');
        }

        return true;
    }
}
