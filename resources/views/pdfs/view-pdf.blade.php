<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{ str_replace(' ', '-', strtolower($clients->policy_holder))."-".date('d-m-Y') }}</title>
  <style>
    html,
    body {
      min-width: auto;
      background: #ffff;
      font-family: 'Helvetica', 'Arial', sans-serif;
      font-size: 9pt;
      margin: 10px;
      box-sizing: content-box;
    }

    table, thead {
      margin: 0px;
      /*border-spacing: 0;*/
    }



    #questions{
      background-color: #0081b8;
      color: #fff;
    }
  </style>
</head>

<body>
  <table cellpadding="5">
    <thead style="color:#000; " id="table-head">
      <tr>
        {{-- <th>
          <img src="{{ public_path('assets/img/EliteInsure_Horizontal.png') }}" alt="" width="100px">
        </th> --}}
        {{-- <th></th> --}}
        <th colspan="2" style="padding: 20px; background-color: #fff">
            <img src="{{ public_path('assets/img/eliteInsure_vertical.png') }}" alt="" width="300px" style="padding-right: 30px; margin-top: 30px;" />
            <h1 style="display: flex; padding-right: 40px; font-size: 40px; margin-bottom: -70px">AUDIT REPORT<h1>
        </th>
      </tr>
      <tr style="background-color: #0f6497; color: #fff;">
        <th align="left">&nbsp;&nbsp;Date: {{date("jS F Y", strtotime(str_replace('/', '-', $clients->audits[0]->pivot->weekOf)))}}</th>
        <th align="left">Lead Source: {{ $clients->audits[0]->pivot->lead_source }}</th>
      </tr>
      <tr style="background-color: #0f6497; color: #fff;">
        <th align="left">&nbsp;&nbsp;Adviser: {{ $adviser_name }} </th>
        <th align="left">Policy Holder: {{ $clients->policy_holder }}</th>
      </tr>
      <tr style="background-color: #0f6497; color: #fff;">
        <th align="left">&nbsp;&nbsp;Caller Name: {{ $caller_name }} </th>
        <th align="left">Caller Email Address: {{ $caller_email }}</th>
      </tr>
    </thead>
    <tr>
      <td></td>
    </tr>
    <tbody>
      @foreach($questions as $index => $qa)
      @if($qa == "Notes:")
      <tr>
        <td></td>
      </tr>
      <tr>
        <td></td>
      </tr>
      @endif
      <tr id="questions">
        <td colspan="2" width="700px">
          <strong>{{ $qa }}</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 10px; ">
          @if(empty($answers[$index]))
          N/A
          @else
            <h4> - {{ ucfirst($answers[$index]) }}</h4>
          @endif
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
</body>

</html>
