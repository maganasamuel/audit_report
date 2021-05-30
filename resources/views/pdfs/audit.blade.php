<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audit Report</title>

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
        <td class="header-title">AUDIT REPORT</td>
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
        <th class="p-2 text-left w-half border-b border-white">&nbsp;&nbsp;Date:
          {{ date('jS F Y', strtotime(str_replace('/', '-', $audit->created_at))) }}
        </th>
        <th class="p-2 text-left w-half border-b border-white">Lead Source:
          {{ $audit->lead_source }}</th>
      </tr>
      <tr>
        <th class="p-2 text-left border-b border-white">&nbsp;&nbsp;Adviser:
          {{ $audit->adviser->name }} </th>
        <th class="p-2 text-left border-b border-white">Policy Holder:
          {{ $audit->client->policy_holder }}
        </th>
      </tr>
      <tr>
        <th class="p-2 text-left border-b border-white">&nbsp;&nbsp;Caller Name:
          {{ $audit->creator->name }}
        </th>
        <th class="p-2 text-left border-b border-white">Caller Email Address:
          {{ $audit->creator->email }}</th>
      </tr>
    </table>
    <br>

    @foreach (config('services.audit.questions') as $key => $question)
      <div style="page-break-inside: avoid;">
        @if ($key == 'notes')
          <p>&nbsp;</p>
        @endif

        <ul id="questions"
          class="text-justify">
          <li class="list-none">
            {{ $question['text'] }}
            <ol type="disc" class="font-bold">
              <li class="mt-4">
                {{ empty($audit->qa[$key]) ? 'N/A' : ucfirst($audit->qa[$key]) }}
              </li>
            </ol>
          </li>
        </ul>
      </div>
    @endforeach
  </div>
</body>

</html>