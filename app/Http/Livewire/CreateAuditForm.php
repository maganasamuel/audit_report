<?php

namespace App\Http\Livewire;

use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;

class CreateAuditForm extends Component
{
    public $advisers;
    public $adviser_id;
    public $lead_source;
    public $is_new_client;

    public $answers = [];

    protected $rules = [

        'adviser_id' => 'required',
        'is_new_client' => 'required',
        'answers.policy_holder' => 'required',
        'answers.policy_no' => 'required',
        'lead_source' => 'required',
        'is_new_client' => 'required',
        'answers.with_policy' => 'required',
        'answers.confirm_adviser' => 'required',
        'answers.bank_account_agreement' => 'required',
        'answers.adviser_scale' => 'required',
        'answers.medical_agreement' => 'required',
        'answers.replace_policy' => 'required',
        'answers.occupation' => 'required',
        'answers.confirm_occupation' => 'required',
        'answers.policy_understanding' => 'required',
        'answers.received_copy' => 'required',
        'answers.replacement_is_discussed' => 'required',
        'answers.is_action_taken' => 'required'
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

        $this->is_new_client = 'yes';

        $this->lead_source = '';

        $this->answers['adviser_scale'] = 10;

        $this->answers['received_copy'] = 'yes';

        $this->answers['with_policy'] = 'yes';

        $this->answers['confirm_adviser'] = 'yes';

        $this->answers['medical_agreement'] = 'yes';

        $this->answers['bank_account_agreement'] = 'yes';

        $this->answers['replace_policy'] = 'no';

        $this->answers['confirm_occupation'] = '';

        $this->answers['received_copy'] = 'yes';

        $this->answers['replacement_is_discussed'] = 'yes';

        $this->answers['is_action_taken'] = 'yes';

    }

    public function onSubmit()
    {
      
        $this->validate();

        $client = Client::firstOrCreate(

            ['policy_holder' => $this->answers['policy_holder']],
            ['policy_no' => $this->answers['policy_no']]
        );

        $audit = Audit::create([

            'adviser_id' => $this->adviser_id,
            'user_id' => auth()->id(),
            'qa' => json_encode($this->answers)

        ]);

        $client->audits()->attach($audit->id,[
            'weekOf' => Carbon::now()->startOfWeek()->format('Y-m-d'),
            'lead_source' => $this->lead_source,
            'pdf_title' => $client->policy_holder.date('dmYgi', time()).'.pdf'
        ]);

        session()->flash('message', 'Successfully created audit.');
        
        return redirect()->to('/calls/audit');


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
