@extends('layouts.app', ['title' => __('Dashboard')])

@section('content')
  @include('layouts.headers.cards')

  <div class="container-fluid mt--7">
    @include('alerts.success')
    @include('alerts.error')

    @include('audits.edit')
    @include('surveys.edit')

    <div class="card w-100">
      <div class="card-body">
        <h3 class="mb-3">All Made Calls</h3>

        <ul class="nav nav-tabs" id="clientDetailsTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link font-weight-bold px-4 py-2 active" id="auditsTab"
              data-toggle="tab"
              href="#auditsTabItem" role="tab" aria-controls="audits"
              aria-selected="true">Audits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold px-4 py-2" id="surveysTab"
              data-toggle="tab"
              href="#surveysTabItem"
              role="tab" aria-controls="surveys" aria-selected="false">Surveys</a>
          </li>
        </ul>
        <div class="tab-content" id="clientDetailsTab">
          <div class="tab-pane fade show active" id="auditsTabItem"
            role="tabpanel"
            aria-labelledby="auditsTab">
            @livewire('audits.index')
          </div>
          <div class="tab-pane fade" id="surveysTabItem" role="tabpanel"
            aria-labelledby="surveysTab">
            @livewire('surveys.index')
          </div>
        </div>
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection

@push('scripts')
  <script type="text/javascript">
    const handleHomeLoad = () => {
      $(document).on('audit-updated', function(event) {
        console.log('audit-updated');
        $('#editAuditModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });

      $(document).on('audit-mailed', function(event) {
        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });

      $(document).on('audit-deleted', function(event) {
        $('#deleteAuditModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });

      $(document).on('survey-updated', function(event) {
        $('#editSurveyModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });

      $(document).on('survey-mailed', function(event) {
        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });

      $(document).on('survey-deleted', function(event) {
        $('#deleteSurveyModal').modal('hide');

        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });
    }

    window.addEventListener('load', handleHomeLoad);

  </script>
@endpush
