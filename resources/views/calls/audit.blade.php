@extends('layouts.app', ['title' => __('Adviser Profiles')])

@section('content')
@include('users.partials.header', [
  'title' => __('Audit Questionnaire'),
  'description' => __('This is the Audit Questionnaire. You can see different sets of questions.'),
  'class' => 'col-lg-12'
  ])

  <!-- Kevin 3-->
  <div class="container-fluid mt--7">
    @include('alerts.success')
    <div class="card w-100 rounded-0">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Audit Report</h3>
        </div>
        <div class="assessment-container">
          <div class="row">
            <div class="col-lg-12 pt-0 form-box">
                @livewire('create-audit-form')
            </div>
          </div>
        </div>
      </div>
    </div>


    @include('layouts.footers.auth')
  </div>


  
  <script>
    
  </script>

  @endsection