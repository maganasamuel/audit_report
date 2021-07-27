<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Feedback Report</title>

  <link rel="stylesheet" href="/css/pdf.css" />

  <style>
    .questions {
      background-color: #fff;
      color: #000;
    }

    .info-table {
      border: 1px solid #f2f2f2;
    }

    .info-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .bg-info {
      background-color: #f2f2f2;
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
        <td class="header-title">CLIENT FEEDBACK REPORT</td>
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
    <table class="w-full info-table">
      <tr>
        <th colspan="4" class="p-2 text-left font-bold">Adviser Information</th>
      </tr>
      <tr>
        <td class="p-2 w-quart">Name of Financial Adviser:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->name }}</td>
        <td class="p-2 w-quart">Finance Advice Provider Name:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->fap_name }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">FSP Number:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->fsp_no }}</td>
        <td class="p-2 w-quart">FAP FSP Number:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->fap_fsp_no }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Contact Number:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->contact_number }}</td>
        <td class="p-2 w-quart">FAP Contact Number:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->fap_contact_number }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Email Address:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->email }}</td>
        <td class="p-2 w-quart">FAP Email Address:</td>
        <td class="p-2 w-quart">{{ $audit->adviser->fap_email }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Physical Address:</td>
        <td class="p-2" colspan="3">{{ $audit->adviser->address }}</td>
      </tr>
      <tr style="background-color: white;">
        <th colspan="4" class="p-2 text-left font-bold"><br>Caller Information</th>
      </tr>
      <tr>
        <td class="p-2 w-quart">Name of Caller:</td>
        <td class="p-2 w-quart">{{ $audit->creator->name }}</td>
        <td class="p-2 w-quart">Email Address:</td>
        <td class="p-2 w-quart">{{ $audit->creator->email }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Date of the Call:</td>
        <td class="p-2 w-quart">{{ $audit->created_at->format('d/m/Y') }}</td>
        <td class="p-2 w-quart">Time of the Call:</td>
        <td class="p-2 w-quart">{{ $audit->created_at->format('h:i A') }}</td>
      </tr>
      <tr>
        <th colspan="4" class="p-2 text-left font-bold"><br>Client Information</th>
      </tr>
      <tr>
        <td class="p-2 w-quart">Name of Client:</td>
        <td class="p-2 w-quart">{{ $audit->client->policy_holder }}</td>
        <td class="p-2 w-quart">Policy Number:</td>
        <td class="p-2 w-quart">{{ $audit->client->policy_no }}</td>
      </tr>
    </table>
    <br>



    @if ($audit->client_answered)
      @foreach (config('services.audit.questions') as $key => $question)
        <div style="page-break-inside: avoid;">
          @if ($key == 'notes')
            <p>&nbsp;</p>
          @endif

          <ul class="questions text-justify mb-0 {{ $question['text'] ? 'mt-8' : 'mt-0' }}">
            <li class="list-none">
              <div class="{{ $question['pdf_class'] ?? '' }}">{{ $question['text'] }}</div>
              <ol type="{{ $question['text'] ? 'disc' : 'none' }}" class="font-bold ">
                @if (!empty($audit->qa[$key]))
                  <li class="{{ $question['text'] ? 'mt-4' : 'mt-0' }}">
                    {{ ucfirst($audit->qa[$key]) }}
                  </li>
                @endif
              </ol>
            </li>
          </ul>
        </div>
      @endforeach
    @else
      <p>The Caller attempted to call the client three times however, the client did not answer the call. The date and time of those three attempts are as provided below:</p>
      <ul>
        @foreach ($audit->call_attempts ?? [] as $index => $call_attempt)
          <li>{{ ordinalNumber($index + 1) }} attempt: {{ $call_attempt }}</li>
        @endforeach
      </ul>
    @endif
  </div>
</body>

</html>
