<?php

namespace App\Http\Livewire\Advisers;

use App\Actions\Advisers\CreateAdviser;
use App\Actions\Advisers\UpdateAdviser;
use App\Models\Adviser;
use Livewire\Component;

class Form extends Component
{
    public $input = [];

    public $adviserId;

    protected $listeners = ['editAdviser'];

    public function getAdviserProperty()
    {
        return $this->adviserId ? Adviser::findOrFail($this->adviserId) : null;
    }

    public function render()
    {
        return view('livewire.advisers.form');
    }

    public function resetInput()
    {
        $this->adviserId = null;

        $this->input = [];
    }

    public function editAdviser($adviserId)
    {
        $this->adviserId = $adviserId;

        $this->input = $this->adviser->only([
            'name',
            'fsp_no',
            'status',
        ]);
    }

    public function submit()
    {
        $this->adviserId ? $this->updateAdviser() : $this->createAdviser();
    }

    public function createAdviser()
    {
        $action = new CreateAdviser();

        $adviser = $action->create($this->input);

        $this->dispatchBrowserEvent('adviser-created', $adviser->name . ' with FSP Number ' . $adviser->fsp_no . ' has been added!');
    }

    public function updateAdviser()
    {
        $action = new UpdateAdviser();

        $action->update($this->input, $this->adviser);

        $this->dispatchBrowserEvent('adviser-updated', 'Successfully updated adviser.');
    }
}
