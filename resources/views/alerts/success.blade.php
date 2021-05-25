<div class="alert alert-success alert-with-icon d-none" id="success">
  <a href="javascript:void(0)" aria-hidden="true" class="close"
    aria-label="close">
    &times;
  </a>
  <span data-notify="icon" class="tim-icons icon-trophy"></span>
  <span id="success-text"></span>
</div>

@push('scripts')
  <script type="text/javascript">
    $('#success').on('click', function() {
      $(this).removeClass('d-block').addClass('d-none');
    })

  </script>
@endpush
