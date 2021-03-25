@extends('layouts.app', ['title' => __('Survey')])

@section('content')
@include('users.partials.header', [
  'title' => __('Survey Process'),
  'description' => __('This is the Survey Process. You can see different sets of questions.'),
  'class' => 'col-lg-12'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    <div class="card w-100">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Survey</h3>
        </div>
        <div class="container-fluid">
          <div class="card">
            <div class="card-body survey">
              <div class="row">
                <div class="form-group col-lg-12 col-md-12">
                  <input type="text" class="form-control" placeholder="Week of" id="week-of" value="{{ date('d-m-Y') }}" required>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:3px;">
                <div class="row">
                  <div class="form-group col-lg-12 col-md-12">
                    <select class="form-control" name="adviser" id="adviser" required>
                      <option value="" selected disabled>Select an Adviser</option>
                      @foreach($advisers as $adviser)
                      <option value="{{ $adviser->id }}">{{$adviser->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-lg-12">Is this a new client?</label>
                <div class="form-group col-lg-12">
                  <select id="client-question" class="form-control">
                    <option value="" selected disabled>Choose an option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
                </div>
              </div>
              <div id="if-new-client"></div>
              <div class="form-group survey-qa">
                <label>Have you had a chance to discuss this cancellation with your Adviser?</label>
                <select id="level-1" class="form-control">
                  <option value="" selected disabled>Choose an option</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>

            </div>
          </div>
          
        </div>


        {{-- <div class="form-group">
          <label>Did your Adviser explain the differences between your Partners Life Policy and your new replacement insurance Policy?</label>
          <select id="level-1" class="form-control">
            <option value="" selected disabled>Choose an option</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div> --}}
      </div>
    </div>


    @include('layouts.footers.auth')
  </div>



  <link type="text/css" href="{{ asset('custom-css') }}/survey-custom-style.css?v=1.0.0" rel="stylesheet">
  @include('custom-scripts.survey-js')
  @endsection