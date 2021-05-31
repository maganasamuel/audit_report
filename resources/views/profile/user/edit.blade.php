@extends('layouts.app', ['title' => 'Edit Profile'])

@section('content')
  @include('layouts.headers.cards')

  <div class="container-fluid mt--7">
    @include('alerts.success')
    @include('alerts.error')

    <div class="card w-100">
      <div class="card-body">
        <h3 class="mb-4">My Profile</h3>
        @livewire('user-profile.edit')
        <hr>
        @livewire('user-profile.password')
      </div>
    </div>

    @include('layouts.footers.auth')
  </div>
@endsection

@push('scripts')
  <script type="text/javascript">
    const handleUserProfileLoad = () => {
      $(document).on('user-info-updated', function(event) {
        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });

      $(document).on('user-password-updated', function(event) {
        $('#success').removeClass('d-none').addClass('d-block');
        $('#success-text').text(event.detail);
      });
    }

    window.addEventListener('load', handleUserProfileLoad);

  </script>
@endpush
