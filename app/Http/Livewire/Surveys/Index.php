<?php

namespace App\Http\Livewire\Surveys;

use App\Jobs\MailSurvey;
use App\Models\Client;
use App\Models\Survey;
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

    public $surveyId;

    public $completed = 1;

    protected $listeners = ['surveyUpdated' => 'render', 'delete-survey' => 'deleteSurvey'];

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
            $query = $this->client->surveys();
        } else {
            if (auth()->user()->is_admin) {
                $query = Survey::query();
            } else {
                $query = auth()->user()->createdSurveys();
            }
        }

        $query->select([
            'surveys.id',
            DB::raw('concat(adviser.first_name, " ", adviser.last_name) as adviser_name'),
            'surveys.created_at',
            DB::raw('concat(creator.first_name, " ", creator.last_name) as creator_name'),
            DB::raw('concat(updator.first_name, " ", updator.last_name) as updator_name'),
            'surveys.client_answered',
            'client.policy_holder',
            'client.policy_no',
            'surveys.completed',
        ])->leftJoin(config('database.connections.mysql_training.database') . '.ta_user as adviser', function ($join) {
            $join->on('adviser.id_user', 'surveys.adviser_id')
                ->whereNotIn('adviser.id_user_type', config('services.not_user_types'));
        })->leftJoin(config('database.connections.mysql_training.database') . '.ta_user as creator', function ($join) {
            $join->on('creator.id_user', 'surveys.created_by')
                ->whereIn('creator.id_user_type', config('services.user_types'));
        })->leftJoin(config('database.connections.mysql_training.database') . '.ta_user as updator', function ($join) {
            $join->on('updator.id_user', 'surveys.updated_by')
                ->whereIn('updator.id_user_type', config('services.user_types'));
        })->leftJoin('clients as client', 'client.id', 'surveys.client_id')
            ->where('completed', $this->completed)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereRaw('concat(adviser.first_name, " ", adviser.last_name) like ?', '%' . $this->search . '%')
                        ->when(strtotime($this->search), function ($query) {
                            $query->orWhereBetween('surveys.created_at', [
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

        $surveys = $query->paginate($this->perPage);

        return view('livewire.surveys.index', compact('surveys'));
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

    public function mailSurvey(Survey $survey)
    {
        abort_unless($survey->completed, 403, 'Could not send mail. Please make sure that this survey is complete.');

        MailSurvey::dispatch($survey);

        $this->dispatchBrowserEvent('survey-mailed', 'Successfully sent email to manager');
    }

    public function deleteSurvey()
    {
        Session::forget('cannotDelete');
    }

    public function confirmDelete()
    {
        Survey::find($this->surveyId)->delete();

        $this->dispatchBrowserEvent('survey-deleted', 'Successfully deleted survey.');
    }
}
