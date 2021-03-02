<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{ str_replace(' ', '-', strtolower($clients->policy_holder))."-".date('d-m-Y') }}</title>
</head>

<body>
  <table cellpadding="5" cellspacing="5">
    <thead style="background-color:#0c4664; color:#fff;" id="table-head">
      <tr>
        {{-- <th>
          <img src="{{ public_path('assets/img/EliteInsure_Horizontal.png') }}" alt="" width="100px">
        </th> --}}
        {{-- <th></th> --}}
        <th colspan="2">
          {{-- <img src="{{ public_path('assets/img/EliteInsure_Horizontal_White.png') }}" alt="" width="200px"> --}}
          <h1 align="center">&nbsp;&nbsp;Audit Report<h1>
        </th>
      </tr>
      <tr>
        <th align="left">&nbsp;&nbsp;Date: {{date("jS F Y", strtotime(str_replace('/', '-', $clients->audits[0]->pivot->weekOf)))}}</th>
        <th align="left">Lead Source: {{ $clients->audits[0]->pivot->lead_source }}</th>
      </tr>
      <tr>
        <th align="left">&nbsp;&nbsp;Adviser: {{ $adviser_name }} </th>
        <th align="left">Policy Holder: {{ $clients->policy_holder }}</th>
      </tr>
    </thead>
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
      <tr>
        <td colspan="2" width="700px">
          <strong>{{ $qa }}</strong>
        </td>
      </tr>
      <tr>
        <td style="padding-left: 10px;">
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
<style>
  html,
  body {
    min-width: auto;
    background: #EEEEEE;
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 9pt;
    margin: 0;
    box-sizing: content-box;
  }

  table {
    margin: 10px;
    /*border-spacing: 0;*/
  }
</style>