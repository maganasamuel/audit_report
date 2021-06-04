<div>
  <button id="btnAddUser" type="button" class="btn btn-primary">New User</button>

  <div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="userFormModal"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $userId ? 'Edit User' : 'Add a User' }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <input type="text" wire:model.defer="input.name" class="form-control"
                  placeholder="User's Name">
                <x-input-error for="name" />
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-at"></i>
                  </span>
                </div>
                <input type="email" wire:model.defer="input.email" class="form-control"
                  placeholder="Email Address">
                <x-input-error for="email" />
              </div>
            </div>

            @if (!$userId)
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-lock"></i>
                    </span>
                  </div>
                  <input type="password" wire:model.defer="input.password" class="form-control"
                    placeholder="Password">
                  <x-input-error for="password" />
                </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-lock"></i>
                    </span>
                  </div>
                  <input type="password" wire:model.defer="input.password_confirmation" class="form-control"
                    {{ $input['is_admin'] ?? '' ? 'checked' : '' }}
                    placeholder="Confirm Password">
                </div>
              </div>
            @endif

            <div class="form-group row">
              <div class="col-lg-12 d-flex justify-content-start">
                <span class="clearfix"></span>
                <label class="custom-toggle">
                  <input type="checkbox" id="is_admin" value="1" wire:model.defer="input.is_admin">
                  <span class="custom-toggle-slider rounded-circle"></span>
                </label>
                <label class="form-control-label mx-2"> Admin Privileges</label>
              </div>
            </div>

            @if ($userId)
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-tag"></i>
                    </span>
                  </div>
                  <select wire:model.defer="input.status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Deactivated">Deactivated</option>
                  </select>
                  <x-input-error for="status" />
                </div>
              </div>
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="new-user"
            class="btn btn-primary">{{ $userId ? 'Update User' : 'Add User' }}</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
    const handleUserFormLoad = () => {
      $('#btnAddUser').on('click', function() {
        @this.call('resetInput');

        $('#userFormModal').modal('show');
      });
    }

    window.addEventListener('load', handleUserFormLoad);

  </script>
@endpush
