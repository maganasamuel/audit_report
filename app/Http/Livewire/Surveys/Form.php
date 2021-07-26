<?php

namespace App\Http\Livewire\Surveys;

use App\Actions\Surveys\CreateSurvey;
use App\Actions\Surveys\UpdateSurvey;
use App\Models\Adviser;
use App\Models\Client;
use App\Models\Survey;
use Livewire\Component;

class Form extends Component
{
    public $profileClientId;

    public $input;

    public $surveyId;

    protected $listeners = ['editSurvey'];

    public function getProfileClientProperty()
    {
        return Client::find($this->profileClientId);
    }

    public function getSurveyProperty()
    {
        if (! $this->surveyId) {
            return;
        }

        if ($this->profileClientId) {
            return $this->profileClient->surveys()->findOrFail($this->surveyId);
        }

        if (auth()->user()->is_admin) {
            return Survey::findOrFail($this->surveyId);
        }

        return auth()->user()->createdSurveys()->findOrFail($this->surveyId);
    }

    public function getAdvisersProperty()
    {
        return Adviser::where('status', 'Active')
            ->when(isset($this->input['adviser_name']) && $this->input['adviser_name'], function ($query) {
                $query->where('name', 'like', '%' . $this->input['adviser_name'] . '%');

                return $query;
            })->orderBy('name')->get();
    }

    public function getClientsProperty()
    {
        return Client::when(isset($this->input['client_policy_holder']) && $this->input['client_policy_holder'], function ($query) {
            $query->where('policy_holder', 'like', '%' . $this->input['client_policy_holder'] . '%');

            return $query;
        })->orderBy('policy_holder')->get();
    }

    public function getClientProperty()
    {
        return Client::find($this->input['client_id'] ?? null);
    }

    public function mount($profileClientId = null)
    {
        $this->profileClientId = $profileClientId;

        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.surveys.form');
    }

    public function updated($name, $value)
    {
        if ('input.client_answered' == $name) {
            if (1 == $this->input['client_answered']) {
                unset($this->input['call_attempts']);
            } elseif (0 == $this->input['client_answered']) {
                $this->input['call_attempts'] = ['', '', ''];
                unset($this->input['qa']);
                $this->dispatchBrowserEvent('client-not-answered');
            }
        }

        if ('input.sa.cancellation_discussed' == $name) {
            $this->input['sa']['adviser'] = '';
            $this->input['sa']['benefits_discussed'] = '';
        }

        if ('input.sa.policy_replaced' == $name) {
            $this->input['sa']['policy_explained'] = '';
            $this->input['sa']['risk_explained'] = '';
            $this->input['sa']['insurer'] = '';
        }
    }

    public function resetInput()
    {
        $sa = [];

        foreach (config('services.survey.questions') as $key => $value) {
            $sa[$key] = '';
        }

        $this->input = [
            'adviser_id' => '',
            'is_new_client' => '',
            'client_id' => '',
            'policy_holder' => '',
            'policy_no' => '',
            'sa' => $sa,
        ];
    }

    public function editSurvey($surveyId)
    {
        $this->surveyId = $surveyId;

        $data = $this->survey->only([
            'adviser_id',
            'client_id',
            'sa',
            'client_answered',
            'call_attempts',
        ]);

        $data['adviser_name'] = Adviser::find($data['adviser_id'])->name;
        $data['client_policy_holder'] = Client::find($data['client_id'])->policy_holder;
        $data['is_new_client'] = 'no';

        $this->input = $data;

        $this->dispatchBrowserEvent('edit-survey');
    }

    public function submit()
    {
        $this->surveyId ? $this->updateSurvey() : $this->createSurvey();
    }

    public function createSurvey()
    {
        $action = new CreateSurvey();

        $action->create($this->input);

        $this->dispatchBrowserEvent('survey-created', 'Successfully added a Survey.');

        $this->resetInput();
    }

    public function updateSurvey()
    {
        $action = new UpdateSurvey();

        $action->update($this->input, $this->survey);

        $this->emitTo('surveys.index', 'surveyUpdated');

        $this->dispatchBrowserEvent('survey-updated', 'Successfully updated survey.');
    }
}
