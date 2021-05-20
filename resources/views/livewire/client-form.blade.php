<div>
    <form wire:submit.prevent="onSubmit">

        <div class="form-group">
            <label for="policy_holder" class="text-sm">{{ __('Policy Holder') }}</label>
            
            <input id="policy_holder" class="form-control" wire:model.lazy="policy_holder" placeholder="Enter Policy Holder">

            @error('policy_holder')
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        
        </div>

        <div class="form-group">
            <label for="policy_no" class="text-sm">{{ __('Policy Number') }}</label>
            
            <input id="policy_no" class="form-control" wire:model.lazy="policy_no" placeholder="Enter Policy Number">

            @error('policy_no')
                <span class="invalid-feedback" style="display: block;" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary"><i class="fa fa-circle-o-notch fa-spin d-none m-1"></i>{{ $client ? 'Save' : 'Submit' }}</button>
        </div>
       
    </form>

</div>
