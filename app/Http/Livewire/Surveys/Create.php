<?php

namespace App\Http\Livewire\Surveys;

use App\Actions\Surveys\CreateSurvey;
use App\Models\Adviser;
use App\Models\Client;
use Livewire\Component;

class Create extends Component
{
    public $input;

    public $showQuestions = [
        1 => 411,
        2 => 5,
        3 => 511,
        4 => 512,
        5 => 6,
        6 => 7,
        7 => 8,
        8 => 9,
    ];

    public $temp;

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

    public function getShowQuestion411Property()
    {
        return ($this->input['sa']['answers'][0]) == 'Yes' ? true : false;
    }

    public function getShowQuestion5Property()
    {
        $answer4 = $this->input['sa']['answers'][0];

        if ('No' == $answer4) {
            return true;
        }

        if ('Yes' == $answer4 && ($this->input['sa']['answers'][1])) {
            return true;
        }

        return false;
    }

    public function getShowQuestion511Property()
    {
        $answer5 = $this->input['sa']['answers'][2];

        return 'Yes' == $answer5 ? true : false;
    }

    public function getShowQuestion512Property()
    {
        $answer511 = $this->input['sa']['answers'][3];

        return $answer511 ? true : false;
    }

    public function getShowQuestion6Property()
    {
        $answer4 = $this->input['sa']['answers'][0];

        if ('No' == $answer4) {
            return false;
        }

        $answer5 = $this->input['sa']['answers'][2];

        if ('No' == $answer5) {
            return true;
        }

        $answer511 = $this->input['sa']['answers'][3];

        $answer512 = $this->input['sa']['answers'][4];

        if ('Yes' == $answer5 && $answer511 && $answer512) {
            return true;
        }

        return false;
    }

    public function getShowQuestion7Property()
    {
        $answer4 = $this->input['sa']['answers'][0];

        $answer5 = $this->input['sa']['answers'][2];

        $answer512 = $this->input['sa']['answers'][4];

        $answer6 = $this->input['sa']['answers'][5];

        if ('Yes' == $answer4 && $answer6) {
            return true;
        }

        if ('No' == $answer4 && 'No' == $answer5) {
            return true;
        }

        if ('No' == $answer4 && 'Yes' == $answer5 && $answer512) {
            return true;
        }

        return false;
    }

    public function getShowQuestion8Property()
    {
        $answer5 = $this->input['sa']['answers'][2];

        $answer7 = $this->input['sa']['answers'][6];

        return 'Yes' == $answer5 && $answer7 ? true : false;
    }

    public function getShowQuestion9Property()
    {
        $answer5 = $this->input['sa']['answers'][2];

        $answer7 = $this->input['sa']['answers'][6];

        $answer8 = $this->input['sa']['answers'][7];

        if ('Yes' == $answer5 && $answer8) {
            return true;
        }

        if ('No' == $answer5 && $answer7) {
            return true;
        }

        return false;
    }

    public function getShowSubmitProperty()
    {
        $answer2 = $this->input['adviser_id'] ?? '';
        $answer3 = $this->input['new_client'] ?? '';
        $answer311 = $this->input['policy_holder'] ?? '';
        $answer312 = $this->input['policy_no'] ?? '';
        $answer321 = $this->input['client_id'] ?? '';
        $answer4 = $this->input['sa']['answers'][0];
        $answer411 = $this->input['sa']['answers'][1];
        $answer5 = $this->input['sa']['answers'][2];
        $answer511 = $this->input['sa']['answers'][3];
        $answer512 = $this->input['sa']['answers'][4];
        $answer6 = $this->input['sa']['answers'][5];
        $answer7 = $this->input['sa']['answers'][6];
        $answer8 = $this->input['sa']['answers'][7];
        $answer9 = $this->input['sa']['answers'][8];

        if (! $answer2) {
            return false;
        }

        if (! $answer3) {
            return false;
        }

        if ('Yes' == $answer3 && ! ($answer311 && $answer312)) {
            return false;
        }

        if ('No' == $answer3 && ! $answer321) {
            return false;
        }

        if (! $answer4) {
            return false;
        }

        if ('Yes' == $answer4 && ! ($answer411 && $answer6)) {
            return false;
        }

        if (! $answer5) {
            return false;
        }

        if ('Yes' == $answer5 && ! ($answer511 && $answer512 && $answer8)) {
            return false;
        }

        if (! $answer7) {
            return false;
        }

        if (! $answer9) {
            return false;
        }

        return true;
    }

    public function mount()
    {
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.surveys.create');
    }

    public function updated($name, $value)
    {
        if ('input.new_client' == $name) {
            $this->input['policy_holder'] = '';
            $this->input['policy_no'] = '';
            $this->input['client_id'] = '';
        }

        if ('input.sa.answers.0' == $name) {
            $this->input['sa']['answers'][1] = '';
            $this->input['sa']['answers'][5] = '';
        }

        if ('input.sa.answers.2' == $name) {
            $this->input['sa']['answers'][3] = '';
            $this->input['sa']['answers'][4] = '';
            $this->input['sa']['answers'][7] = '';
        }
    }

    public function resetInput()
    {
        $this->input = [
            'sa' => [
                'questions' => config('services.survey.questions'),
                'answers' => array_fill(0, count(config('services.survey.questions')), ''),
            ],
        ];
    }

    public function createSurvey(CreateSurvey $action)
    {
        $action->create($this->input);

        $this->resetInput();

        $this->dispatchBrowserEvent('survey-created', 'Successfully added a Survey.');
    }
}
