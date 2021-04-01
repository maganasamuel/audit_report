@extends('layouts.app', ['title' => __('Reports')])

@section('content')
@include('users.partials.header', [
  'title' => __('Reports'),
  'description' => __('This is Reports . You can see data from the previous audits and surveys we generated.'),
  'class' => 'col-lg-12'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    <div class="card w-100">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Reports</h3>
        </div>
        <div class="container-fluid">
          <div class="card">
            <div class="card-body report">
              <form action="{{ route('reports.pdf') }}" method="POST">
                @csrf

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-label">Report Type: </label>
                      <select class="form-control" name="report_type" required>
                        <option value="" disabled selected>Choose an option.</option>
                        <option value="audit">Audit</option>
                        <option value="survey">Survey</option>
                      </select>
                      
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Select an Adviser: </label>
                        <select class="form-control" id="advisers" name="adviser" required>
                          <option value="" disabled selected>Choose an option</option>
                          @foreach($advisers as $adviser)
                            <option value={{ $adviser->id }}>{{ $adviser->name }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">FSP Number: </label>
                        <input class="form-control" type="text" id="fsp_no" name="fsp_no" disabled>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>From: </label>
                      <input id="startDate" class="form-control" name="startDate" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label >To: </label>
                      <input id="endDate" class="form-control" name="endDate" required>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 text-center">
                  <button class="btn btn-primary" type="submit">Submit</button>
                  
                </div>
              </form>
            </div>{{-- card-body --}}
          </div>
          
        </div>

      </div>
    </div>


    @include('layouts.footers.auth')
  </div>

  @include('custom-scripts.report-js')
  <link type="text/css" href="{{ asset('custom-css') }}/custom-style.css?v=1.0.0" rel="stylesheet">
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  
  <script>
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
      $('#startDate').datepicker({
        format: "dd-mm-yyyy",
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        maxDate: function () {
            return $('#endDate').val();
        }
      });
      $('#endDate').datepicker({
        format: "dd-mm-yyyy",
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        minDate: function () {
            return $('#startDate').val();
        }
    });
  </script>
  @endsection