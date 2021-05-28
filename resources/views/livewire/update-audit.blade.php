<div>
  <div wire:ignore.self class="modal right fade" id="updateAuditModal"
    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            {{ __('Edit Audit') }}</h5>
          <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">
          @if ($audit)
            @livewire('audits.form', ['audit' => $audit])
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
