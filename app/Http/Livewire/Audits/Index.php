<?php

namespace App\Http\Livewire\Audits;

use App\Jobs\MailAudit;
use App\Models\Audit;
use App\Models\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $componentId;

    public $clientId;

    public $perPage = 10;

    public $search;

    public $sortColumn = [
        'name' => '',
        'direction' => '',
    ];

    public $auditId;

    public $completed = 1;

    protected $listeners = ['auditUpdated' => 'render', 'draftAuditUpdated' => 'render', 'delete-audit' => 'deleteAudit'];

    protected $paginationTheme = 'bootstrap';

    public function getClientProperty()
    {
        return Client::findOrFail($this->clientId);
    }

    public function mount($clientId = null)
    {
        $this->componentId = Str::random(10);

        $this->clientId = $clientId;
    }

    public function render()
    {
        if ($this->clientId) {
            $query = $this->client->audits();
        } else {
            if (auth()->user()->is_admin) {
                $query = Audit::query();
            } else {
                $query = auth()->user()->createdAudits();
            }
        }

        $query->select([
            'audits.id',
            DB::raw('concat(adviser.first_name, " ", adviser.last_name) as adviser_name'),
            // 'audits.lead_source',
            'audits.created_at',
            DB::raw('concat(creator.first_name, " ", creator.last_name) as creator_name'),
            DB::raw('concat(updator.first_name, " ", updator.last_name) as updator_name'),
            'audits.client_answered',
            'client.policy_holder',
            'client.policy_no',
            'audits.completed',
        ])->leftJoin(config('database.connections.mysql_training.database') . '.ta_user as adviser', function ($join) {
            $join->on('adviser.id_user', 'audits.adviser_id')
                ->whereNotIn('adviser.id_user_type', config('services.not_adviser_types'));
        })->leftJoin(config('database.connections.mysql_training.database') . '.ta_user as creator', function ($join) {
            $join->on('creator.id_user', 'audits.created_by')
                ->whereIn('creator.id_user_type', config('services.user_types'));
        })->leftJoin(config('database.connections.mysql_training.database') . '.ta_user as updator', function ($join) {
            $join->on('updator.id_user', 'audits.updated_by')
                ->whereIn('updator.id_user_type', config('services.user_types'));
        })->leftJoin('clients as client', 'client.id', 'audits.client_id')
            ->where('completed', $this->completed)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereRaw('concat(adviser.first_name, " ", adviser.last_name) like ?', '%' . $this->search . '%')
                        // ->orWhere('audits.lead_source', 'like', '%' . $this->search . '%')
                        ->when(strtotime($this->search), function ($query) {
                            $query->orWhereBetween('audits.created_at', [
                                Carbon::parse($this->search)->startOfDay()->toDateTimeString(),
                                Carbon::parse($this->search)->endOfDay()->toDateTimeString(),
                            ]);

                            return $query;
                        })->when($this->clientId, function ($query) {
                            $query->orWhereRaw('concat(creator.first_name, " ", creator.last_name) like ?', '%' . $this->search . '%');

                            return $query;
                        })->orWhereRaw('concat(updator.first_name, " ", updator.last_name) like ?', '%' . $this->search . '%')
                        ->when(! $this->clientId, function ($query) {
                            $query->orWhere('client.policy_holder', 'like', '%' . $this->search . '%')
                                ->orWhere('client.policy_no', 'like', '%' . $this->search . '%');

                            return $query;
                        });
                });

                return $query;
            });

        if ($this->sortColumn['name'] && $this->sortColumn['direction']) {
            $query->orderBy($this->sortColumn['name'], $this->sortColumn['direction']);
        } else {
            $query->orderBy('id', 'desc');
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
        abort_unless($audit->completed, 403, 'Could not send mail. Please make sure that this client feedback is complete.');

        MailAudit::dispatch($audit);

        $this->dispatchBrowserEvent('audit-mailed', 'Successfully sent email to manager.');
    }

    public function deleteAudit()
    {
        Session::forget('cannotDelete');
    }

    public function confirmDelete()
    {
        Audit::find($this->auditId)->delete();

        $this->dispatchBrowserEvent('audit-deleted', 'Successfully deleted client feedback.');
    }
}
