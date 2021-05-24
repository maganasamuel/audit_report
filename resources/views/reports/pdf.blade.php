<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Reports PDF </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
          .audits-table td {
            border: 1px solid black;
            padding: 5px;
          }

          .header-table td {
            border: 1px solid black;
            padding: 5px;
          }

          .audits-table tr:nth-child(even) {
            background-color: #f2f2f2;
          }
        </style>
    </head>
    <body>
      <img src="{{ public_path('assets/img/eliteInsure_vertical.png') }}" alt="" width="100px" style="margin-bottom: 30px;" />
      <div style="text-align: center; background-color: #adcdea; padding: 10px; border: 2px solid black">
        <h1>
          <strong>Adviser Summary</strong>
        </h1>
      </div>
      <table class="header-table" width="100%" style="border: 1px solid black; border-spacing: 0">
        <tr>
          <td><strong>Name:</strong> {{ $adviser->name }}</td>
          <td><strong>FSP no.</strong> {{ $adviser->fsp_no }}</td>
        </tr>
        <tr>
          <td><strong>Date generated: </strong> {{ $date }}</td>
          <td><strong>Period Covered: </strong> {{ $start_date }} - {{ $end_date }}</td>
        </tr>
      </table>
      <div style="text-align: center;">
        <h2>
          <strong style="text-decoration: underline;">Audits</strong>
        </h2>
      </div>

      <table class="audits-table" width="100%" style="border-spacing: 0; border: 1px solid black;">
        <tr>
          <td style="text-align: center; background-color: #adcdea;"><strong>Title</strong></td>
          <td style="text-align: center; background-color: #adcdea;"><strong>Percentage %</strong></td>
        </tr>
        <tr>
          <td>
            <strong>No. of Clients Audited:</strong>
          </td>
          <td style="text-align: center;">{{ $total_clients }}</td>
        </tr>
        <tr>
          <td>
            <strong>Adviser Standard of Service Rating:</strong>
          </td>
          <td style="text-align: center;">
            {{ $service_rating }}%
          </td>
        </tr>
        <tr>
          <td><strong>Complete Disclosure by Client:</strong></td>
          <td style="text-align: center;">{{ $disclosure_percentage }}%</td>
        </tr>
        <tr>
          <td><strong>Client Payment Method has been Set: </strong></td>
          <td style="text-align: center;">{{ $payment_percentage }}%</td>
        </tr>
        <tr>
          <td><strong>Client Policy Being Replaced: </strong></td>
          <td style="text-align: center;">{{ $policy_replaced_percentage }}%</td>
        </tr>
        <tr>
          <td><strong>Client Provided Correct Occupation: </strong></td>
          <td style="text-align: center;">{{ $correct_occupation_percentage }}%</td>
        </tr>
        <tr>
          <td><strong>Compliance Documents Received by Client: </strong></td>
          <td style="text-align: center;">{{ $compliance_percentage }}%</td>
        </tr>
        <tr>
          <td><strong>Explanation of Risk in Replacement: </strong></td>
          <td style="text-align: center;">{{ $replacement_risks_percentage }}%</td>
        </tr>
      </table>
      
    </body>
</html>