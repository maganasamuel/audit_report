<?php

namespace App\Http\Livewire\Surveys;

use App\Jobs\MailSurvey;
use App\Models\Client;
use App\Models\Survey;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $clientId;

    public $perPage = 10;

    public $search;

    public $sortColumn = [
        'name' => '',
        'direction' => '',
    ];

    public $surveyId;

    protected $listeners = ['surveyUpdated' => 'render', 'delete-survey' => 'deleteSurvey'];

    protected $paginationTheme = 'bootstrap';

    public function getClientProperty()
    {
        return Client::findOrFail($this->clientId);
    }

    public function mount($clientId = null)
    {
        $this->clientId = $clientId;
    }

    public function render()
    {
        if ($this->clientId) {
            $query = $this->client->surveys();
        } else {
            $query = auth()->user()->createdSurveys();
        }

        $query->select(
            'surveys.id',
            'adviser.name as adviser_name',
            'surveys.created_at',
            'creator.name as creator_name',
            'updator.name as updator_name',
            'client.policy_holder',
            'client.policy_no'
        )->leftJoin('advisers as adviser', 'adviser.id', 'surveys.adviser_id')
            ->leftJoin('users as creator', 'creator.id', 'surveys.created_by')
            ->leftJoin('users as updator', 'updator.id', 'surveys.updated_by')
            ->leftJoin('clients as client', 'client.id', 'surveys.client_id')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('adviser.name', 'like', '%' . $this->search . '%')
                        ->when(strtotime($this->search), function ($query) {
                            $query->orWhereBetween('surveys.created_at', [
                                Carbon::parse($this->search)->startOfDay()->toDateTimeString(),
                                Carbon::parse($this->search)->endOfDay()->toDateTimeString(),
                            ]);

                            return $query;
                        })->when($this->clientId, function ($query) {
                            $query->orWhere('creator.name', 'like', '%' . $this->search . '%');

                            return $query;
                        })->orWhere('updator.name', 'like', '%' . $this->search . '%')
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
