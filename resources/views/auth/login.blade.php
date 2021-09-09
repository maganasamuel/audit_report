@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
  @include('layouts.headers.guest')

  <div class="container mt--8 pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        @if (session()->has('status'))
          <div class="alert alert-danger alert-with-icon" id="error">
            <a href="#" aria-hidden="true" class="close" data-dismiss="alert" aria-label="close" style="line-height: 0!important;">&times;</a>
            <span data-notify="icon" class="tim-icons icon-trophy"></span>
            <span id="danger-text">{{ __('Your account has been terminated. Please contact Administrator.') }}</span>
          </div>
        @endif
        <div class="card bg-secondary shadow border-0">
          <div class="card-header bg-transparent pb-3 text-center">
            <h1 style="font-weight: heavy;"><strong>{{ __('CLIENT FEEDBACK') }}</strong></h1>
            <h1><strong>{{ __('SOFTWARE') }}</strong></h1>
          </div>
          <div class="card-body px-lg-5 py-lg-5">
            @if ($errors->any())
              <div class="alert alert-danger" role="alert">
                Could not login from {{ config('services.training.web') }}. Please make sure that you have valid credentials. Please try again.
              </div>
            @endif
            <p>Please login using this website:</p>
            <p class="font-weight-bold"><a href="{{ config('services.training.url') }}">{{ config('services.training.web') }}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
