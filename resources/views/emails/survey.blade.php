@component('mail::message')
  <img src="{{ asset('assets/img/EliteInsure_Horizontal.png') }}"
    width="200px" />

  <br><br>

  # Hello {{ $survey->creator->name }},

  Here's survey report of {{ $survey->client->policy_holder }} with policy
  number:
  {{ $survey->client->policy_no }}.

  @component('mail::button', ['url' => config('app.url')])
    Visit Site
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }} Management
@endcomponent
