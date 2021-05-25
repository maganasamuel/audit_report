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
        @livewire('surveys.create')
      </div>
    </div>
    @include('layouts.footers.auth')
  </div>

  @include('custom-scripts.survey-js')
@endsection
