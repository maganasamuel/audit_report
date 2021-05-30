@extends('layouts.app', ['title' => __('Client Profiles')])

@section('content')
  @include('users.partials.header', [
  'title' => __("Policy No: $client->policy_no | $client->policy_holder"),
  'description' => __("This is the Client Details. You can see different
  information of the audits and surveys taken by client. You can add, update or
  delete as well."),
  'class' => 'col-lg-7'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    @include('alerts.error')

    @include('audits.edit', ['clientId' => $client->id])
    @include('surveys.edit', ['clientId' => $client->id])

    <div class="card">
      <div class="card-body">
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
            @livewire('audits.index', ['clientId' => $client->id])
          </div>
          <div class="tab-pane fade" id="surveysTabItem" role="tabpanel"
            aria-labelledby="surveysTab">
            @livewire('surveys.index', ['clientId' => $client->id])
          </div>
        </div>
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection

@push('scripts')
  <script type="text/javascript">
    window.onload = () => {
      $(function() {
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
          $('#deleteModal').modal('hide');

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
          $('#deleteModal').modal('hide');

          $('#success').removeClass('d-none').addClass('d-block');
          $('#success-text').text(event.detail);
        });
      });
    }

  </script>
@endpush
