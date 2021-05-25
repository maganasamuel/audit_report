<div>
  <div wire:ignore.self class="modal right fade" id="editClientModal"
    tabindex="-1" role="dialog" aria-labelledby="editClientModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{ __('Edit Client') }}</h5>
          <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">
          @if ($clientId)
            <div>
              <form wire:submit.prevent="updateClient">

                <div class="form-group">
                  <label for="policy_holder"
                    class="text-sm">{{ __('Policy Holder') }}</label>

                  <input id="policy_holder" class="form-control"
                    wire:model.lazy="input.policy_holder"
                    placeholder="Enter Policy Holder">

                  @error('policy_holder')
                    <span class="invalid-feedback" style="display: block;"
                      role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror

                </div>

                <div class="form-group">
                  <label for="policy_no"
                    class="text-sm">{{ __('Policy Number') }}</label>

                  <input id="policy_no" class="form-control"
                    wire:model.lazy="input.policy_no"
                    placeholder="Enter Policy Number">

                  @error('policy_no')
                    <span class="invalid-feedback" style="display: block;"
                      role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror

                </div>

                <div class="form-group mt-4">
                  <button type="submit" class="btn btn-primary"><i
                      class="fa fa-circle-o-notch fa-spin d-none m-1"></i>Edit</button>
                </div>

              </form>

            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
