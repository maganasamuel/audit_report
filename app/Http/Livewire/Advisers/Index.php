<?php

namespace App\Http\Livewire\Advisers;

use App\Models\Adviser;
use Illuminate\Support\Facades\DB;
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
        '0' => 'badge bg-danger text-white',
        '1' => 'badge bg-success text-white',
    ];

    public $statusLabel = [
        '0' => 'Inactive',
        '1' => 'Active',
    ];

    protected $paginationTheme = 'bootstrap';

    public function getAdviserProperty()
    {
        return Adviser::findOrFail($this->adviserId);
    }

    public function render()
    {
        $searchColumns = [
            'concat(first_name, " ", last_name)',
            'email_address',
            'ssf_number',
            'status',
        ];

        $query = Adviser::select([
            'id_user',
            DB::raw('concat(first_name, " ", last_name) as name'),
            'email_address',
            'ssf_number',
            'status',
        ])->when($this->search, function ($query) use ($searchColumns) {
            foreach ($searchColumns as $column) {
                $query->orWhereRaw($column . ' like ?', '%' . $this->search . '%');
            }

            return $query;
        });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        } else {
            $query->orderBy('id_user', 'desc');
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
        if ($this->adviser->audits()->count()) {
            Session::flash('cannotDelete', 'Cannot delete adviser. Please make sure that there are no client feedbacks with this adviser.');

            return false;
        }

        if ($this->adviser->surveys()->count()) {
            Session::flash('cannotDelete', 'Cannot delete adviser. Please make sure that there are no surveys with this adviser.');
        }

        return true;
    }
}
