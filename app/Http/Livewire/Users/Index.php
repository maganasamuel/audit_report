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
        'name' => 'user_name',
        'direction' => 'asc',
    ];

    public $userId;

    public $typeBadgeClass = [
        '1' => 'badge bg-primary text-white',
        '7' => 'badge bg-success text-white',
        '8' => 'badge bg-success text-white',
    ];

    public $statusBadgeClass = [
        '0' => 'badge bg-danger text-white',
        '1' => 'badge bg-success text-white',
    ];

    public $statusLabel = [
        '0' => 'Inactive',
        '1' => 'Active',
    ];

    protected $paginationTheme = 'bootstrap';

    public function getUserProperty()
    {
        if (! $this->userId) {
            return;
        }

        return User::where('id_user', '!=', auth()->user()->id_user)->where('id_user', $this->userId)->firstOrFail();
    }

    public function render()
    {
        $searchColumns = [
            'concat(first_name, " ", last_name)',
            'email_address',
        ];

        $query = User::select([
            'id_user',
            DB::raw('concat(first_name, " ", last_name) as user_name'),
            'email_address',
            'id_user_type',
            'status',
        ])->where('id_user', '!=', auth()->user()->id_user)
            ->when($this->search, function ($query) use ($searchColumns) {
                $query->where(function ($query) use ($searchColumns) {
                    foreach ($searchColumns as $column) {
                        $query->orWhereRaw($column . ' like ?', '%' . $this->search . '%');
                    }
                });

                return $query;
            });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        } else {
            $query->orderBy('id_user', 'desc');
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
