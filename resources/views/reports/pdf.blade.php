<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audit Report</title>

  <link rel="stylesheet" href="/css/pdf.css" />

  <style>
    .audits-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .bg-gray {
      background-color: #adcdea;
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
    <div class="text-center bg-gray p-4 border border-2">
      <h1 class="font-bold">Adviser Summary</h1>
    </div>
    <table class="header-table" class="w-full border">
      <tr>
        <td class="border p-2"><span class="font-bold">Name:</span>
          {{ $adviser->name }}</td>
        <td class="border p-2"><span class="font-bold">FSP No.</span>
          {{ $adviser->fsp_no }}</td>
      </tr>
      <tr>
        <td class="border p-2"><span class="font-bold">Date Generated:</span>
          {{ $date }}
        </td>
        <td class="border p-2"><span class="font-bold">Period Covered:</span>
          {{ $start_date }} -
          {{ $end_date }}</td>
      </tr>
    </table>
    <div class="text-center">
      <h2 class="font-bold underline">Audits</h2>
    </div>

    <table class="audits-table w-full border">
      <tr>
        <td class="border p-2 font-bold text-center bg-gray">Title</td>
        <td class="border p-2 font-bold text-center bg-gray">Percentage %</td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">No. of Clients Audited:</td>
        <td class="border p-2 text-center">{{ $total_clients }}</td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Adviser Standard of Service Rating:
        </td>
        <td class="border p-2 text-center">{{ $service_rating }}%</td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Complete Disclosure by Client:</td>
        <td class="border p-2 text-center">
          {{ $disclosure_percentage }}%</td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Client Payment Method has been Set:
        </td>
        <td class="border p-2 text-center">{{ $payment_percentage }}%</td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Client Policy Being Replaced:</td>
        <td class="border p-2 text-center">{{ $policy_replaced_percentage }}%
        </td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Client Provided Correct Occupation:
        </td>
        <td class="border p-2 text-center">
          {{ $correct_occupation_percentage }}%
        </td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Compliance Documents Received by
          Client:</td>
        <td class="border p-2 text-center">{{ $compliance_percentage }}%</td>
      </tr>
      <tr>
        <td class="border p-2 font-bold">Explanation of Risk in Replacement:
        </td>
        <td class="border p-2 text-center">
          {{ $replacement_risks_percentage }}%</td>
      </tr>
    </table>
  </div>
</body>

</html>
