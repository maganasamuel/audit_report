<div>
    <form wire:submit.prevent="onSubmit">

        <div class="form-top">
            <p>
            INTRODUCTION: Mr/ Mrs Policyholder, my name is_____________. I am the Client Relationship manager with EliteInsure Ltd.. The reason for my SPECIAL call is to inspect the standard of service provided by our adviser, ( mention name), and also to ensure that high quality of service and advise was given to you. It should take approx 5 mins. Would that be alright?

            </p>
        </div>

        <div class="form-bottom">
    
            <div class="row">
                <div class="form-group col-lg-12 col-md-12">
                    <input type="text" class="form-control" placeholder="Week of" id="week-of" value="{{ date('d-m-Y') }}" required>
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
                    <select class="form-control" name="lead_source" id="lead_source">
                        <option value="" selected disabled>Select a Lead Source</option>
                        
                        <option value="Telemarketer">Telemarketer</option>
                        <option value="BDM">BDM</option>
                        <option value="Self-generated">Self-generated</option>
                    </select>

                    @error('adviser_id')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
                        
            <div class="form-group">
                <label>Is this a new client?</label>
                <select id="client-question" class="form-control" wire:model.lazy="is_new_client">
                    <option value="" selected disabled>Choose an option</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

        
            @if($is_new_client == true)
                <div class="row">
                
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control" placeholder="Enter Policy Holder">
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="text" class="form-control" placeholder="Enter Policy No.">
                    </div>
                </div>
            @endif
  
            <div class="form-group mb-3">
                <label>Notes: </label>
                <textarea name="notes" class="form-control questions" cols="10" rows="3"></textarea>

            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-circle-o-notch fa-spin d-none m-1"></i>Save</button>
        </div>
       
    </form>
</div>
