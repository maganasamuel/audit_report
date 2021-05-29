@component('mail::message')
  <img src="{{ asset('assets/img/EliteInsure_Horizontal.png') }}"
    width="200px" />

  <br><br>

  # Hello Admin Account,

  Here's audit report of {{ $audit->client->policy_holder }} with policy number:
  {{ $audit->client->policy_no }}.

  @component('mail::button', ['url' => config('app.url')])
    Visit Site
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }} Management
@endcomponent
