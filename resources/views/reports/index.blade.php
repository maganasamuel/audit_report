@extends('layouts.app', ['title' => __('Reports')])

@section('content')
@include('users.partials.header', [
  'title' => __('Reports'),
  'description' => __('This is Reports . You can see data from the previous audits and surveys we generated.'),
  'class' => 'col-lg-12'
  ])

  <div class="container-fluid mt--7">
    @include('alerts.success')
    <div class="card rounded-0 p-4">
      <div class="card-body">
        <div class="card-title">
          <h3 class="mb-0">Reports</h3>
        </div>
         @livewire('report-form')

      </div>
    </div>


    @include('layouts.footers.auth')
  </div>

  @push('js')
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  @endpush

  {{--@include('custom-scripts.report-js')
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
  </script>--}}
  @endsection