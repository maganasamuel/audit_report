<div>
    <form wire:submit.prevent="onSubmit">

        <div class="form-top mb-4">
            <p>
            INTRODUCTION: Mr/ Mrs Policyholder, my name is <span class="text-uppercase"><ins>{{auth()->user()->name}}</ins></span>. I am the Client Relationship manager with EliteInsure Ltd.. The reason for my SPECIAL call is to inspect the standard of service provided by our adviser, ( mention name), and also to ensure that high quality of service and advise was given to you. It should take approx 5 mins. Would that be alright?

            </p>
        </div>

        <hr>

        <div class="form-bottom">
    
            <div class="row">
                <div class="form-group col-lg-12 col-md-12">
                    <h5 class="text-sm">{{ \Carbon\Carbon::now()->toFormattedDateString() }}</h5>
                </div>
            </div>
     
            <div class="row">
                <div class="form-group col-lg-6 col-md-12">
                    <select class="form-control" name="adviser" id="adviser" wire:model.lazy="adviser_id">
                        <option value="" selected>Select an Adviser</option>
                        @foreach($advisers as $adviser)
                            <option value="{{ $adviser->id }}">{{$adviser->name}}</option>
                        @endforeach
                    </select>

                    @error('adviser_id')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-12">
                    <select class="form-control" name="lead_source" id="lead_source" wire:model.lazy="answers.lead_source">
                        <option value="" selected disabled>Select a Lead Source</option>
                        
                        <option value="Telemarketer">Telemarketer</option>
                        <option value="BDM">BDM</option>
                        <option value="Self-generated">Self-generated</option>
                    </select>

                    @error('answers.lead_source')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
                        
            <div class="form-group">
                <label class="text-sm">Is this a new client?</label>
                <select id="client-question" class="form-control" wire:model.lazy="answers.is_new_client">
                    <option value="" selected disabled>Choose an option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                @error('answers.is_new_client')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

       
            
            <div class="row">
               
                <div class="form-group col-lg-6">
                    <input type="text" class="form-control" placeholder="Enter Policy Holder" wire:model.lazy="answers.policy_holder">

                    @error('answers.policy_holder')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-lg-6">
                    <input type="text" class="form-control" placeholder="Enter Policy No." wire:model.lazy="answers.policy_no">

                    @error('answers.policy_no')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <hr class="py-2">

            <div class="form-group">
                <label class="text-sm">1. I understand you recently took out a policy with (fidelity, partners, aia) from one of our advisers Is that correct? </label>
                <select class="form-control questions" wire:model.lazy="answers.with_policy">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                @error('answers.with_policy')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">2. Was the adviser by him / herself?</label>
                <select class="form-control questions" wire:model.lazy="answers.confirm_adviser">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                @error('answers.confirm_adviser')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
  
            <div class="form-group">
                <label class="text-sm">3. How would you describe the adviser's standard of service on a scale of 1-10? (10 is the highest)</label>
                <select class="form-control questions" wire:model.lazy="answers.adviser_scale">
                    @for($x = 10; $x >= 1; $x--)
                    <option value='{{ $x }}'>{{ $x }}</option>
                    @endfor
                </select>

                @error('answers.adviser_scale')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="text-sm">4. As you are aware, non disclosure can lead to non payment of claim. To make sure the correct underwriting takes place , we have noted your current pre-existing medical conditions are </label>
                <input class="form-control" wire:model.lazy="answers.medical_conditions" placeholder="Enter Medical Conditions">

                @error('answers.medical_conditions')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group">
                <label class="text-sm">Is there anything else apart from this not stated? </label>
                <select class="form-control questions" wire:model.lazy="answers.medical_agreement">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes - refer to notes">Yes - Refer to Notes</option>
                    <option value="no">No</option>
                    <option value="not sure - refer to notes">Not Sure - Refer to Notes</option>
                </select>

                @error('answers.medical_agreement')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">5. We have received authority for all future payments to be direct debited from your bank account? Is this correct? </label>
                <select class="form-control" wire:model.lazy="answers.bank_account_agreement">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no - refer to notes">No - Refer to Notes</option>
                </select>

                @error('answers.bank_account_agreement')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        
            <div class="form-group">
                <label class="text-sm">6. Did you take this policy to replace any other policy? </label>
                <select class="form-control" wire:model.lazy="answers.replace_policy">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                @error('answers.replace_policy')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">7. We have your occupation recorded as</label>
                
                <input class="form-control" wire:model.lazy="answers.occupation" placeholder="Enter Occupation">

                @error('answers.occupation')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
           
            </div>

            <div class="form-group">

                <label class="text-sm">Is that correct? </label></label>
                <select class="form-control" wire:model.lazy="answers.confirm_occupation">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no - refer to notes">No - Refer to Notes</option>
                </select>
                @error('answers.confirm_occupation')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">8. What is your understanding of the benefits of the policy? </label>
                <textarea wire:model.lazy="answers.policy_understanding" class="form-control questions" cols="10" rows="3"></textarea>
                @error('answers.policy_understanding')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">9. It specified in the authority to proceed that a copy of the disclosure statement was given to you and your insurance planner and or plan/copy of your LAT was e mailed to e mail address John@eliteinsure..co.nz . Did you received them? </label>
                <select class="form-control " wire:model.lazy="answers.received_copy">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                @error('answers.received_copy')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">10. Do you have any further comments? </label>
                <textarea class="form-control questions" cols="10" rows="3" wire:model.lazy="answers.further_comments"></textarea>
                @error('answers.further_comments')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="text-sm">11. If replacement, were the risks of replacing this insurance policy explained to you? </label>
                <select class="form-control" wire:model.lazy="answers.replacement_is_discussed">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                    <option value="n/a">Not Applicable</option>
                </select>

                @error('answers.replacement_is_discussed')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="text-sm">12. Remedial Action Taken Or Proposed:</label>
                <select class="form-control questions" wire:model.lazy="answers.is_action_taken">
                    <option value="" selected disabled>Select an Answer</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                @error('answers.is_action_taken')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
   
            <div class="form-group">
                <label class="text-sm">Notes: </label>
                <textarea name="notes" class="form-control questions" cols="10" rows="3" wire:model.lazy="answers.notes"></textarea>

            </div>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary"><i class="fa fa-circle-o-notch fa-spin d-none m-1"></i>{{ $audit ? 'Save' : 'Submit' }}</button>
        </div>
       
    </form>
</div>
