<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Feedback Report</title>

  <link rel="stylesheet" href="/css/pdf.css" />

  <style>
    #questions {
      background-color: #fff;
      color: #000;
    }

  </style>
</head>

<body>
  <htmlpageheader name="page-header-first">
    <table class="header">
      <tr>
        <td class="header-left-box">
          &nbsp;
        </td>
        <td class="header-image"><img
            src="{{ asset('assets/img/logo-only.png') }}"
            height="0.76in" /></td>
        <td class="header-title">SURVEY REPORT</td>
        <td class="header-right-box">
          &nbsp;
        </td>
      </tr>
    </table>
  </htmlpageheader>
  <htmlpageheader name="page-header">
    <table class="header">
      <tr>
        <td class="header-left-box">
          &nbsp;
        </td>
        <td class="header-image"><img
            src="{{ asset('assets/img/logo-only.png') }}"
            height="0.76in" /></td>
        <td class="header-title">&nbsp;</td>
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
          <img src="{{ asset('assets/img/EliteInsure_Horizontal.png') }}"
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

  <div class="margin">
    <table class="w-full" style="background-color: #adcdea;">
      <tr>
        <th class="p-2 text-left w-half border-b border-white" colspan="2">
          &nbsp;&nbsp;Date:
          {{ date('jS F Y', strtotime(str_replace('/', '-', $survey->created_at))) }}
        </th>
      </tr>
      <tr>
        <th class="p-2 text-left border-b border-white">&nbsp;&nbsp;Adviser:
          {{ $survey->adviser->name }} </th>
        <th class="p-2 text-left border-b border-white">Policy Holder:
          {{ $survey->client->policy_holder }}
        </th>
      </tr>
      <tr>
        <th class="p-2 text-left border-b border-white">&nbsp;&nbsp;Caller Name:
          {{ $survey->creator->name }}
        </th>
        <th class="p-2 text-left border-b border-white">Caller Email Address:
          {{ $survey->creator->email }}</th>
      </tr>
    </table>
    <br>

    @if ($survey->client_answered)
      @foreach (config('services.survey.questions') as $key => $question)
        <div style="page-break-inside: avoid;">
          <ul id="questions"
            class="text-justify">
            <li class="list-circle">
              {{ $question['text'] }}
              <ol type="disc" class="font-bold">
                <li class="mt-4">
                  {{ empty($survey->sa[$key]) ? 'N/A' : ucfirst($survey->sa[$key]) }}
                </li>
              </ol>
            </li>
          </ul>
        </div>
      @endforeach
    @else
      <p>The Caller attempted to call the client three times however, the client did not answer the call. The date and time of those three attempts are as provided below:</p>
      <ul>
        @foreach ($survey->call_attempts ?? [] as $index => $call_attempt)
          <li>{{ ordinalNumber($index + 1) }} attempt: {{ $call_attempt }}</li>
        @endforeach
      </ul>
    @endif
  </div>
</body>

</html>
