<div>
  <div class="modal right fade" id="editAuditModal"
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
          @livewire('audits.form')
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
    window.onload = () => {
      $(function() {
        $(document).on('audit-updated', function(event) {
          $('#success').removeClass('d-none').addClass('d-block');
          $('#success-text').text(event.detail);

          $('#editAuditModal').modal('hide');
        });
      })
    }

  </script>
@endpush