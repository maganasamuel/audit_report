@extends('layouts.app', ['title' => __('Adviser Profiles')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Audit Questionnaire'),
        'description' => __('This is the Audit Questionnaire. You can see different sets of questions.'),
        'class' => 'col-lg-12'
    ])   

    <div class="container-fluid mt--7">
      <div class="card w-100">
        <div class="card-body">
          <div class="card-title">
            <h3 class="mb-0">Audit Report</h3>
          </div>
            <div class="assessment-container container">
                <div class="row">
                    <div class="col-lg-12 pt-0 form-box">
                        <form role="form" class="registration-form" action="javascript:void(0);">
                            <fieldset>
                                <div class="form-top">
                                </div>
                                <div class="form-bottom">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-6">
                                            <input type="text" class="form-control" placeholder="Week of" id="fname">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6">
                                            <input type="text" class="form-control" placeholder="Lastname" id="lname">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:3px;">
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <select class="form-control">
                                                    <option value="" selected disabled>Select an Adviser</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <input type="text" class="form-control" placeholder="Lead Source" id="lead_source">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" placeholder="Email" class="form-email form-control" id="email" required>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control">
                                            <option>Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    
                                    <button type="button" class="btn btn-next">Next</button>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-top">
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
