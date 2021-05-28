@extends('layouts.app', ['title' => __('Adviser Profiles')])
@section('content')
  @include('users.partials.header', [
  'title' => __('Audit Questionnaire'),
  'description' => __('This is the Audit Questionnaire. You can see different sets
  of questions.'),
  'class' => 'col-lg-12'
  ])

  <!-- Kevin 3-->
  <div class="container-fluid mt--7">
    {{-- @if (session()->has('message'))
      <div class="alert alert-success alert-dismissible fade show rounded-0"
        role="alert">
        <span class="alert-text"><strong>Success!</strong>
          {{ session('message') }}</span>
        <button type="button" class="close" data-dismiss="alert"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif --}}

    @include('alerts.success');

    <div class="card w-100 p-4">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Audit Report</h3>
        </div>
        <div class="assessment-container">
          <div class="row">
            <div class="col-lg-12 pt-0 form-box">
              @livewire('audits.form')
            </div>
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
        $(document).on('audit-created', function(event) {
          $('#success').removeClass('d-none').addClass('d-block');
          $('#success-text').text(event.detail);

          window.scrollTo(0, 0);
        });
      });
    };

  </script>
@endpush
