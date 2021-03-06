@props(['id'])

<div wire:ignore.self class="modal fade" id="{{ $id ?? 'deleteModal' }}"
  tabindex="-1" role="dialog" aria-labelledby="modal-notification"
  aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-"
    role="document">
    <div class="modal-content bg-gradient-danger">
      <div class="modal-header">
        <h4 class="modal-title" id="modal-title-notification">Your attention is
          required</h4>
        <button type="button" class="close" data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="py-3 text-center">
          <i class="ni ni-bell-55 ni-3x"></i>
          <h4 class="heading mt-4">You should read this!</h4>
          <p id="delete-modal-text">
            {{ Session::get('cannotDelete', 'Are you sure you want to delete?') }}
          </p>
        </div>
      </div>

      <div class="modal-footer">
        @if (!Session::has('cannotDelete'))
          <button wire:click="confirmDelete" type="button"
            class="btn btn-white">Ok, Got it</button>
        @endif
        <button type="button" class="btn btn-link text-white ml-auto"
          data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
