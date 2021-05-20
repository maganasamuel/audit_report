<?php

namespace App\Http\Livewire\Advisers;

use App\Actions\Advisers\CreateAdviser;
use Livewire\Component;

class Create extends Component
{
    public $input = [];

    public function render()
    {
        return view('livewire.advisers.create');
    }

    public function createAdviser(CreateAdviser $action)
    {
        $adviser = $action->create($this->input);

        $this->input = [];

        $this->dispatchBrowserEvent('adviser-created', $adviser->name . ' with FSP Number ' . $adviser->fsp_no . ' has been added!');
    }
}
