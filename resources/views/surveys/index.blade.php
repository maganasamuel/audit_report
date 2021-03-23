@extends('layouts.app', ['title' => __('All Surveys')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Surveys'),
        'description' => __('This is the Surveys table. You can see different information of the surveys generated.'),
        'class' => 'col-lg-7'
    ])   

    <div class="container-fluid mt--7">
      @if(session()->has('message'))
        <div class="alert alert-success alert-with-icon" id="successmail">
            <a href="#" aria-hidden="true" class="close" data-dismiss="alert" aria-label="close">
              &times;
            </a>
            <span data-notify="icon" class="tim-icons icon-trophy"></span>
            <span id="success-text">{{ session()->get('message') }}</span>
        </div>
      @endif
      @include('alerts.success')
      @include('alerts.error')
      <div class="card w-100">
        <div class="card-body">
          <div class="card-title d-flex">
            
          </div>
        <table class="table" id="survey-table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Policy Holder</th>
                    <th>Policy Number</th>
                    <th class="text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
              {{-- data fetched via ajax should be inside here --}}
            </tbody>
        </table>
        </div>
      </div>
        
      @include('layouts.footers.auth')
    </div>

  @include('custom-scripts.surveys-js')
@endsection
