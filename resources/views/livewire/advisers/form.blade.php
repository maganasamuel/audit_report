<div>
  <button id="btnAddAdviser" type="button" class="btn btn-primary">
    Add an Adviser
  </button>

  <div class="modal fade" id="adviserFormModal" tabindex="-1" role="dialog"
    aria-labelledby="adviserFormModal" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $adviserId ? 'Update Information of the Adviser' : 'Add an Adviser' }}
          </h5>
          <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container">
          <form wire:submit.prevent="submit">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-user"></i>
                  </span>
                </div>
                <input type="text" id="name" class="form-control"
                  placeholder="Adviser Name"
                  wire:model.defer="input.name">
              </div>
              <x-input-error for="name" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-envelope"></i>
                  </span>
                </div>
                <input type="text" id="email" class="form-control"
                  placeholder="E-Mail"
                  wire:model.defer="input.email">
              </div>
              <x-input-error for="email" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-hashtag"></i>
                  </span>
                </div>
                <input type="text" id="fsp_no" class="form-control"
                  placeholder="FSP Number"
                  wire:model.defer="input.fsp_no">
              </div>
              <x-input-error for="fsp_no" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-phone"></i>
                  </span>
                </div>
                <input type="text" id="contact_number" class="form-control"
                  placeholder="Contact Number"
                  wire:model.defer="input.contact_number">
              </div>
              <x-input-error for="contact_number" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" id="address" class="form-control"
                  placeholder="Address"
                  wire:model.defer="input.address">
              </div>
              <x-input-error for="address" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-user"></i>
                  </span>
                </div>
                <input type="text" id="fap_name" class="form-control"
                  placeholder="FAP Name"
                  wire:model.defer="input.fap_name">
              </div>
              <x-input-error for="fap_name" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-envelope"></i>
                  </span>
                </div>
                <input type="text" id="fap_email" class="form-control"
                  placeholder="FAP Email"
                  wire:model.defer="input.fap_email">
              </div>
              <x-input-error for="fap_email" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-hashtag"></i>
                  </span>
                </div>
                <input type="text" id="fap_fsp_no" class="form-control"
                  placeholder="FAP FSP Number"
                  wire:model.defer="input.fap_fsp_no">
              </div>
              <x-input-error for="fap_fsp_no" />
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-phone"></i>
                  </span>
                </div>
                <input type="text" id="fap_contact_number" class="form-control"
                  placeholder="FAP Contact Number"
                  wire:model.defer="input.fap_contact_number">
              </div>
              <x-input-error for="fap_contact_number" />
            </div>
            @if ($adviserId)
              <div class="form-group">
                <select wire:model.defer="input.status" class="form-control">
                  <option value="">Select Status</option>
                  <option value="Active">Active</option>
                  <option value="Terminated">Terminated</option>
                </select>
                <x-input-error for="status" />
              </div>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
            data-dismiss="modal">Close</button>
          <button type="submit" id="add" class="btn btn-primary"><i
              class="fa fa-circle-o-notch fa-spin d-none m-1"
              style="font-size: 10px;"></i>{{ $adviserId ? 'Update' : 'Add Adviser' }}</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>


@push('scripts')
  <script type="text/javascript">
    const handleAdviserFormLoad = () => {
      $('#btnAddAdviser').on('click', function() {
        @this.call('resetInput');

        $('#adviserFormModal').modal('show');
      });
    }

    window.addEventListener('load', handleAdviserFormLoad);

  </script>
@endpush
