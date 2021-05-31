<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    public $userId;

    public $badgeClass = [
        'Active' => 'badge bg-success text-white',
        'Deactivated' => 'badge bg-danger text-white',
        '0' => 'badge bg-success text-white',
        '1' => 'badge bg-primary text-white',
    ];

    protected $paginationTheme = 'bootstrap';

    public function getUserProperty()
    {
        if (! $this->userId) {
            return;
        }

        return User::where('id', '!=', auth()->user()->id)->where('id', $this->userId)->firstOrFail();
    }

    public function render()
    {
        $searchColumns = [
            'name',
            'email',
            'status',
        ];

        $query = User::withTrashed()
            ->where('id', '!=', auth()->user()->id)
            ->when($this->search, function ($query) use ($searchColumns) {
                $query->where(function ($query) use ($searchColumns) {
                    foreach ($searchColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $this->search . '%');
                    }

                    $query->orWhereRaw('(case when is_admin then "Admin" else "User" end) like ?', '%' . $this->search . '%');
                });

                return $query;
            });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        } else {
            $query->orderBy('id', 'desc');
        }

        $users = $query->paginate($this->perPage);

        return view('livewire.users.index', compact('users'));
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

    public function deleteUser($userId)
    {
        $this->userId = $userId;
    }

    public function confirmDelete()
    {
        $this->user->delete();

        $this->dispatchBrowserEvent('user-deleted', 'User has been deleted.');
    }
}
