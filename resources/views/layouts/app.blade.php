<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    {{ (isset($title) ? $title . ' | ' : '') . config('app.name', 'Survey Software') }}
  </title>

  <!-- Favicon -->
  {{-- <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png"> --}}

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
    rel="stylesheet">

  <!-- Extra details for Live View on GitHub Pages -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Icons -->
  <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css"
    rel="stylesheet">
  <link
    href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css"
    rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0"
    rel="stylesheet">
  <link type="text/css" href="{{ asset('argon') }}/css/custom.css?v=1.0.0"
    rel="stylesheet">

  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet" />

  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

  <link href="{{ mix('css/main.css') }}" rel="stylesheet">

  @livewireStyles

  @stack('styles')
</head>

<body class="{{ $class ?? '' }}">
  @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">
      @csrf
    </form>
    @include('layouts.navbars.sidebar')
  @endauth

  <div class="main-content">
    @include('layouts.navbars.navbar')
    @yield('content')
  </div>

  @guest()
    @include('layouts.footers.guest')
  @endguest

  <!-- Javascripts -->
  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js" defer>
  </script>
  <script
    src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js" defer>
  </script>

  <script type="text/javascript"
    src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" defer>
  </script>

  <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0" defer></script>

  <script
    src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer>
  </script>

  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js" defer></script>
  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js" defer>
  </script>

  @livewireScripts

  @stack('scripts')
</body>

</html>
