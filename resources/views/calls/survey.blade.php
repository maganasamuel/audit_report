@extends('layouts.app', ['title' => __('Survey')])

@section('content')
@include('users.partials.header', [
  'title' => __('Survey Process'),
  'description' => __('This is the Survey Process. You can see different sets of questions.'),
  'class' => 'col-lg-12'
  ])

  <!-- Kevin 3-->
  <div class="container-fluid mt--7">
    <div class="card w-100">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Survey</h3>
        </div>
        <div class="container-fluid">
          <div class="card card-1">
            <div class="card-body survey">
              <div class="form-group">
                <label>Have you had a chance to discuss this cancellation with your Adviser?</label>
                <select id="first" class="form-control">
                  <option value="" selected disabled>Choose an option</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>

            </div>
          </div>
          
        </div>


        <div class="form-group">
          <label>Did your Adviser explain the differences between your Partners Life Policy and your new replacement insurance Policy?</label>
          <select id="level" class="form-control">
            <option value="" selected disabled>Choose an option</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
      </div>
    </div>


    @include('layouts.footers.auth')
  </div>



  <link type="text/css" href="{{ asset('custom-css') }}/survey-custom-style.css?v=1.0.0" rel="stylesheet">
  @include('custom-scripts.survey-js')
  @endsection