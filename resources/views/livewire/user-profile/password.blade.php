<div>
  <h6 class="heading-small text-muted">Update Password</h6>
  <form wire:submit.prevent="updateUserPassword">
    <div class="form-group">
      <label for="old_password">Old Password</label>
      <input type="password" id="old_password" wire:model.defer="input.old_password" class="form-control" />
      <x-input-error for="old_password" />
    </div>
    <div class="form-group">
      <label for="password">New Password</label>
      <input type="password" id="password" wire:model.defer="input.password" class="form-control" />
      <x-input-error for="password" />
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirm New Password</label>
      <input type="password" id="password_confirmation" wire:model.defer="input.password_confirmation"
        class="form-control" />
    </div>
    <button type="submit" class="btn btn-primary">Update Password</button>
  </form>
</div>
