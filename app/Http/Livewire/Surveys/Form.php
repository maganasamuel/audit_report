<?php

namespace App\Http\Livewire\Surveys;

use App\Actions\Surveys\CreateSurvey;
use App\Models\Adviser;
use App\Models\Client;
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
        if ($this->surveyId) {
            return $this->profileClient->surveys()->findOrFail($this->surveyId);
        }

        return;
    }

    public function getAdvisersProperty()
    {
        return Adviser::orderBy('name')->get();
    }

    public function getClientsProperty()
    {
        return Client::orderBy('policy_holder')->get();
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
        ]);

        $data['is_new_client'] = 'no';

        $this->input = $data;
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

        $this->dispatchBrowserEvent('survey-updated', 'Successfully updated survey.');
    }
}
