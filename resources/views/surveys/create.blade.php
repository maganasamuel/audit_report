@extends('layouts.app', ['title' => __('Survey')])

@section('content')
  @include('users.partials.header', [
  'title' => __('Survey Process'),
  'description' => __('This is the Survey Process. You can see different sets of
  questions.'),
  'class' => 'col-lg-12'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')

    <div class="card w-100">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Survey</h3>
        </div>
        @livewire('surveys.form')
      </div>
    </div>
    @include('layouts.footers.auth')
  </div>

  @push('scripts')
    <script type="text/javascript">
      const handleCreateSurveyLoad = () => {
        $(document).on('survey-created draft-survey-created', function(event) {
          $('#success').removeClass('d-none').addClass('d-block');
          $('#success-text').text(event.detail);

          window.scrollTo(0, 0);
        });
      }

      window.addEventListener('load', handleCreateSurveyLoad);
    </script>
  @endpush
@endsection
