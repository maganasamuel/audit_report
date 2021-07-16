<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Feedback Report</title>

  <link rel="stylesheet" href="/css/pdf.css" />

  <style>
    .table-striped {
      border: 1px solid #f2f2f2;
    }

    .table-striped tr:nth-child(even) {
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
    <div class="section-title mb-4 text-center">Adviser Summary</div>
    <table class="table-striped w-full">
      <tr>
        <td class="p-2 w-quart">Name of Financial Adviser:</td>
        <td class="p-2 w-quart">{{ $adviser->name }}</td>
        <td class="p-2 w-quart">Finance Advice Provider Name:</td>
        <td class="p-2 w-quart">{{ $adviser->fap_name }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">FSP Number:</td>
        <td class="p-2 w-quart">{{ $adviser->fsp_no }}</td>
        <td class="p-2 w-quart">FAP FSP Number:</td>
        <td class="p-2 w-quart">{{ $adviser->fap_fsp_no }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Contact Number:</td>
        <td class="p-2 w-quart">{{ $adviser->contact_number }}</td>
        <td class="p-2 w-quart">FAP Contact Number:</td>
        <td class="p-2 w-quart">{{ $adviser->fap_contact_number }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Email Address:</td>
        <td class="p-2 w-quart">{{ $adviser->email }}</td>
        <td class="p-2 w-quart">FAP Email Address:</td>
        <td class="p-2 w-quart">{{ $adviser->fap_email }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart">Physical Address:</td>
        <td class="p-2 w-quart" colspan="3">{{ $adviser->address }}</td>
      </tr>
      <tr>
        <td class="p-2 w-quart font-bold">Date Generated:</td>
        <td class="p-2 w-quart">{{ $date }}</td>
        <td class="p-2 w-quart font-bold">Period Covered:</td>
        <td class="p-2 w-quart">
          {{ $start_date }} -
          {{ $end_date }}
        </td>
      </tr>
    </table>

    <p class="mt-4">&nbsp;</p>

    <div class="section-title text-center mb-4 mt-8">Client Feedbacks</div>

    <table class="table-striped w-full">
      <tr>
        <td class="p-2 font-bold text-center bg-gray">Title</td>
        <td class="p-2 font-bold text-center bg-gray">Percentage %</td>
      </tr>
      <tr>
        <td class="p-2 font-bold">No. of Client Feedbacks:</td>
        <td class="p-2 text-center">{{ $total_clients }}</td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Adviser Standard of Service Rating:
        </td>
        <td class="p-2 text-center">{{ round($service_rating) }}%</td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Complete Disclosure by Client:</td>
        <td class="p-2 text-center">
          {{ round($disclosure_percentage) }}%</td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Client Payment Method has been Set:
        </td>
        <td class="p-2 text-center">{{ round($payment_percentage) }}%</td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Client Policy Being Replaced:</td>
        <td class="p-2 text-center">{{ round($policy_replaced_percentage) }}%
        </td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Client Provided Correct Occupation:
        </td>
        <td class="p-2 text-center">
          {{ round($correct_occupation_percentage) }}%
        </td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Compliance Documents Received by
          Client:</td>
        <td class="p-2 text-center">{{ round($compliance_percentage) }}%</td>
      </tr>
      <tr>
        <td class="p-2 font-bold">Explanation of Risk in Replacement:
        </td>
        <td class="p-2 text-center">
          {{ round($replacement_risks_percentage) }}%</td>
      </tr>
    </table>
  </div>
</body>

</html>
