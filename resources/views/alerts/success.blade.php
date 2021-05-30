<div class="alert alert-success alert-with-icon d-none" id="success">
  <button type="button" aria-hidden="true" class="close"
    aria-label="close"
    onclick="let success = this.closest('#success'); success.classList.remove('d-block'); success.classList.add('d-none');">
    &times;
  </button>
  <span data-notify="icon" class="tim-icons icon-trophy"></span>
  <span id="success-text"></span>
</div>
