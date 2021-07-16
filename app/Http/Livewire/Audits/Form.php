<?php

namespace App\Http\Livewire\Audits;

use App\Actions\Audits\CreateAudit;
use App\Actions\Audits\UpdateAudit;
use App\Models\Adviser;
use App\Models\Audit;
use App\Models\Client;
use Livewire\Component;

class Form extends Component
{
    public $profileClientId;

    public $auditId;

    public $input;

    protected $listeners = ['editAudit'];

    public function getProfileClientProperty()
    {
        return Client::find($this->profileClientId);
    }

    public function getAuditProperty()
    {
        if (! $this->auditId) {
            return;
        }

        if ($this->profileClientId) {
            return $this->profileClient->audits()->findOrFail($this->auditId);
        }

        return auth()->user()->createdAudits()->findOrFail($this->auditId);
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
        return Client::find($this->input['client_id']);
    }

    public function mount($profileClientId = null)
    {
        $this->profileClientId = $profileClientId;

        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.audits.form');
    }

    public function resetInput()
    {
        $this->input = [
            'adviser_id' => '',
            'is_new_client' => '',
            'client_id' => '',
            'policy_holder' => '',
            'policy_no' => '',
            'lead_source' => '',
            'qa' => [
                'with_policy' => '',
                'confirm_adviser' => '',
                'adviser_scale' => 10,
                'medical_conditions' => '',
                'medical_agreement' => '',
                'bank_account_agreement' => '',
                'replace_policy' => '',
                'occupation' => '',
                'confirm_occupation' => '',
                'policy_understanding' => '',
                'received_copy' => '',
                'replacement_is_discussed' => '',
                'is_action_taken' => '',
                'notes' => '',
            ],
        ];
    }

    public function updated($name, $value)
    {
        if ('input.qa.medical_agreement' == $name && ! in_array($value, ['yes', 'not sure'])) {
            $this->input['qa']['medical_conditions'] = '';
        }

        if ('input.qa.confirm_occupation' == $name && 'no' != $value) {
            $this->input['qa']['occupation'] = '';
        }
    }

    public function editAudit($auditId)
    {
        $this->auditId = $auditId;

        $data = $this->audit->only([
            'adviser_id',
            'client_id',
            'lead_source',
            'qa',
        ]);

        $data['adviser_name'] = Adviser::find($data['adviser_id'])->name;
        $data['client_policy_holder'] = Client::find($data['client_id'])->policy_holder;
        $data['is_new_client'] = 'no';

        $this->input = $data;

        $this->dispatchBrowserEvent('edit-audit');
    }

    public function submit()
    {
        $this->auditId ? $this->updateAudit() : $this->createAudit();
    }

    public function createAudit()
    {
        $action = new CreateAudit();

        $action->create($this->input);

        $this->dispatchBrowserEvent('audit-created', 'Successfully created client feedback.');

        $this->resetInput();
    }

    public function updateAudit()
    {
        $action = new UpdateAudit();

        $action->update($this->input, $this->audit);

        $this->emitTo('audits.index', 'auditUpdated');

        $this->dispatchBrowserEvent('audit-updated', 'Succuessfully updated client feedback.');
    }
}
