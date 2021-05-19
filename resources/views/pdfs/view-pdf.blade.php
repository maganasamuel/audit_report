<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="{{ public_path('/css/pdf.css') }}" />

  <style>
    body {
      font-family: 'helvetica';
      font-size: 9pt;
    }

    #questions {
      background-color: #fff;
      color: #000;
    }

  </style>
</head>

<body>
  <htmlpageheader name="page-header">
    <table class="header">
      <tr>
        <td class="header-left-box">
          &nbsp;
        </td>
        <td class="header-image"><img
            src="{{ public_path('assets/img/logo-only.png') }}"
            height="0.76in" /></td>
        <td class="header-title">AUDIT REPORT</td>
        <td class="header-right-box">
          &nbsp;
        </td>
      </tr>
    </table>
  </htmlpageheader>
  <htmlpagefooter name="page-footer">
    <table class="table-footer">
      <tr>
        <td class="footer-logo">
          <img src="{{ public_path('assets/img/EliteInsure_Horizontal.png') }}"
            width="2.12in" />
        </td>
        <td class="footer-page">
          <a
            href="{{ config('services.company.url') }}"
            class="footer-link"
            target="_blank">{{ config('services.company.web') }}</a>&nbsp;|&nbsp;Page
          {PAGENO}
        </td>
      </tr>
    </table>
  </htmlpagefooter>

    <div style="page-break-inside: avoid;">
      <div style="background-color:2e74b6; height: 2px;"></div>
    
      <h1  class="title">{{ __('Audit Report') }}</h1>
      <div>
        <p>{{ $audit->pivot->pdf_title }}</p>

        <p>{{ __('Date') }} : {{ $audit->pivot->weekOf }}</p>

        <p>Policy Holder: {{ $client->policy_holder }}</p>
        <p>Policy Number: {{ $client->policy_no}}</p>


        <p>Adiviser: {{ $audit->adviser->name}}</p>
        <p>Lead Source: {{ $lead_source}}</p>


        <p>Caller Name: {{ $audit->caller->name}}</p>
        <p>Caller Email Address: {{ $audit->caller->email}}</p>
      </div>
      <div style="background-color:2e74b6; height: 2px;"></div>

      @foreach($questions as $key => $question)
        <p style="font-size:16px;">{{ $key + 1}} . {{ $question['question'] }}</p>
        <p style="margin-left: 4; text-transform:capitalize;">{{ $question['answer'] }}</p>
      @endforeach
    </div>

  </div>
</body>

</html>
