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
      border-spacing: 0;
    }

    #questions{
      /*background-color: #adcdea;*/
      background-color: #fff;
      color: #000;
    }
  </style>
</head>

<body>
  <table cellpadding="5">
    <thead></thead>
    <tr>
      <td></td>
    </tr>
    <tbody>
      <tr>
        {{-- <th>
          <img src="{{ public_path('assets/img/EliteInsure_Horizontal.png') }}" alt="" width="100px">
        </th> --}}
        {{-- <th></th> --}}
        <th colspan="3" style="padding: 0; background-color: #fff; text-align: left; position: relative;">
            <img src="{{ public_path('assets/img/eliteInsure_vertical.png') }}" alt="" width="100px" style="margin-bottom: 30px;" />
            {{-- <h1 style="display: flex; padding-right: 40px; font-size: 40px; margin-bottom: -70px">AUDIT REPORT<h1> --}}
            <h1 style="position: absolute; top: 31px; right: 300px;">SURVEY</h1>
        </th>
      </tr>
      <tr style="background-color: #adcdea; color: #000;">
        <th align="left" colspan="">&nbsp;&nbsp;Date: {{date("jS F Y", strtotime(str_replace('/', '-', $survey->updated_at)))}}</th>
        <th align="left" colspan="2">Created by: {{ $survey->created_by }}</th>
      </tr>
      <tr style="background-color: #adcdea; color: #000;">
        <th align="left" colspan="">&nbsp;&nbsp;Updated by: {{ $survey->updated_by }}</th>
        <th align="left" colspan="2">Time Updated: {{ date("H:i A", strtotime(str_replace('/', '-', $survey->updated_at)))}}</th>
      </tr>
      <tr style="background-color: #adcdea; color: #000;">
        <th align="left">&nbsp;&nbsp;Adviser: {{ $adviser->name }} </th>
        <th align="left" colspan="2">Policy Holder: {{ $clients->policy_holder }}</th>
      </tr>{{-- 
      <tr style="background-color: #adcdea; color: #000;">
        <th align="left"> </th>
        <th align="left"></th>
      </tr> --}}
      <tr>
        <td></td>
      </tr>
      @foreach($questions as $index => $qa)
      <?php $count =  $index ?>
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
          <strong>{{ ++$count }}. {{ $qa }}</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding-left: 10px; ">
          @if(empty($answers[$index]))
            <strong>N/A</strong>
          @else
            <h4> - {{ ucfirst($answers[$index]) }}</h4>
          @endif
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
  <script type="text/php">
    $pdf->page_script('
        if (true) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 820;
            $x = 260;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
  </script>
</body>

</html>


