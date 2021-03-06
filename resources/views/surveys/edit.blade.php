<div>
  <div class="modal right fade" id="editSurveyModal" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 75vw; max-width: none; !important;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            {{ __('Edit Survey') }}</h5>
          <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">
          @livewire('surveys.form', ['profileClientId' => $clientId ?? null])
        </div>
      </div>
    </div>
  </div>
</div>
