@extends('layouts.app', ['title' => __('Adviser Profiles')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Audit Questionnaire'),
        'description' => __('This is the Audit Questionnaire. You can see different sets of questions.'),
        'class' => 'col-lg-12'
    ])   

<!-- Kevin 2-->
    <div class="container-fluid mt--7">
      <div class="card w-100">
        <div class="card-body">
          <div class="card-title">
            <h3 class="mb-0">Audit Report</h3>
          </div>
            <div class="assessment-container">
                <div class="row">
                    <div class="col-lg-12 w-100 pt-0 form-box">
                        <form role="form" class="registration-form" action="javascript:void(0);">
                    <div class="col-lg-12 pt-0 form-box">
                        <form role="form" class="registration-form" action="{{ route('calls.store_audit') }}">
                            <fieldset>
                                <div class="form-top">
                                  <p>
                                    INTRODUCTION: Mr/ Mrs Policyholder, my name is_____________. I am the Client Relationship manager with EliteInsure Ltd.. The reason for my SPECIAL call is to inspect the standard of service provided by our adviser, ( mention name), and also to ensure that high quality of service and advise was given to you. It should take approx 5 mins. Would that be alright?                                   

                                  </p>
                                </div>
                                <div class="form-bottom">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-12">
                                            <input type="text" class="form-control" placeholder="Week of" id="week-of" value="{{ date('d/m/Y') }}">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <input type="text" class="form-control" placeholder="Lastname" id="lname">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:3px;">
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <select class="form-control" name="adviser" id="adviser" required>
                                                    <option value="" selected disabled>Select an Adviser</option>
                                                    @foreach($advisers as $adviser)
                                                      <option value="{{ $adviser->id }}">{{$adviser->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                              <select class="form-control" name="lead_source" id="lead-source" required>
                                                <option value="" selected disabled>Select an Lead Source</option>
                                              </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="form-group col-lg-6 col-md-12">
                                          <input type="text" name="policy_holder" placeholder="Policy Holder" class="form-email form-control" id="policy-holder" required>
                                      </div>
                                      <div class="form-group col-lg-6 col-md-12">
                                          <input type="text" name="policy_no" id="policy-no" placeholder="Policy No" class="form-control" required>
                                      </div>
                                      
                                    </div>

                                    
                                    <button type="button" class="btn btn-next">Next</button>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-top">
                                  INTRODUCTION: Mr/ Mrs Policyholder, my name is_____________. I am the Client Relationship manager with EliteInsure Ltd.. The reason for my SPECIAL call is to inspect the standard of service provided by our adviser, ( mention name), and also to ensure that high quality of service and advise was given to you. It should take approx 5 mins. Would that be alright? 
                                </div>
                                <div class="form-bottom">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>Location</option>
                                            <option>Location</option>
                                            <option>Location</option>
                                            <option>Location</option>
                                            <option>Locationa</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="pref_date">
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>Preffered Time</option>
                                            <option>Location</option>
                                            <option>Location</option>
                                            <option>Location</option>
                                            <option>Location</option>
                                            <option>Locationa</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button type="submit" class="btn">Submit</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
        
      @include('layouts.footers.auth')
    </div>
    <link type="text/css" href="{{ asset('custom-css') }}/custom-style.css?v=1.0.0" rel="stylesheet">
    @include('custom-scripts.multi-form-js')
@endsection
