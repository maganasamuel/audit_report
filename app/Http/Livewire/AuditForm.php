<?php

namespace App\Http\Livewire;

use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Client;
use Carbon\Carbon;
use Livewire\Component;

class AuditForm extends Component
{
    public $advisers;
    public $adviser_id;

    public $answers = [

        'adviser_scale' => 10,
        'received_copy' => 'yes',
        'with_policy' => 'yes',
        'confirm_adviser' => 'yes',
        'medical_agreement' => 'yes - refer to notes',
        'bank_account_agreement' => 'yes',
        'replace_policy' => 'no',
        'confirm_occupation' => '',
        'received_copy' => 'yes',
        'replacement_is_discussed' => 'yes',
        'is_action_taken' => 'yes',
        'is_new_client' => 'yes',
        'lead_source' => 'Telemarketer'
    ];

    public $audit;

    protected $listeners = ['auditClicked'];

    protected $rules = [

        'adviser_id' => 'required',
        'answers.is_new_client' => 'required',
        'answers.policy_holder' => 'required',
        'answers.policy_no' => 'required',
        'answers.lead_source' => 'required',
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

    }

    public function auditClicked(Audit $audit)
    {
        $this->audit = $audit;

        if($this->audit) {

            $this->answers = json_decode($this->audit->qa, true);
            $this->adviser_id = $this->audit->adviser_id;

        }

    }


    public function onSubmit()
    {

        $this->validate();


        $this->audit ? $this->save() : $this->store();

    }

    public function store()
    {

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
            'lead_source' => $this->answers['lead_source'],
            'pdf_title' => $client->policy_holder.date('-dmYgi', time()).'.pdf'
        ]);

        session()->flash('message', 'Successfully created audit.');

        return redirect()->to('/calls/audit');
    }

    public function save()
    {

        $this->audit->update([

            'adviser_id' => $this->adviser_id,
            'user_id' => auth()->id(),
            'qa' => json_encode($this->answers)
        ]);

        session()->flash('message', 'Successfully Updated Audit.');

        $this->emit('auditUpdate');
    }

    /**
     *
     * Will render the page
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return view('livewire.audit-form');
    }
}
