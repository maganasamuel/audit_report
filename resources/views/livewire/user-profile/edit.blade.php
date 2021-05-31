<div>
  <h6 class="heading-small text-muted">User Information</h6>
  <form wire:submit.prevent="updateUserInfo">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" class="form-control" wire:model.defer="input.name" />
      <x-input-error for="name" />
    </div>
    <div class="form-group">
      <label for="email">E-Mail</label>
      <input type="email" id="email" class="form-control" wire:model.defer="input.email" />
      <x-input-error for="email" />
    </div>

    <button type="submit" class="btn btn-primary">Update Information</button>
  </form>
</div>
