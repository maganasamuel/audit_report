<?php

namespace App\Http\Livewire;

use App\Models\Adviser;
use Livewire\Component;

class CreateAuditForm extends Component
{
    public $advisers;
    public $qa;
    public $adviser_id;
    public $is_new_client;

    protected $rules = [

        'adviser_id' => 'required'
    ];

    /**
     * Will be updated once a field has changed
     *
     * @param string $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    /**
     * 
     * Will start the page
     *
     * @return void
     */
    public function mount()
    {
        $this->advisers = Adviser::orderBy('name')->get();

        $this->is_new_client = 1;
    }

    public function onSubmit()
    {
        $this->validate();
     
    }

    /**
     * 
     * Will render the page
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return view('livewire.create-audit-form');
    }
}
