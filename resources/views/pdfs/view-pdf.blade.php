<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PDF - Template</title>
</head>

<body>
  <table cellpadding="5" cellspacing="5">
    <thead style="background-color:#30375F;color:#fff">
      <tr>
        <th>
          <h1 align="left">&nbsp;&nbsp;Audit Report<h1>

          </th>
          <th></th>
        </tr>
        <tr>
          {{-- <th align="left">&nbsp;&nbsp;Date : <?= date("jS F Y", strtotime(str_replace('/', '-', $date))); ?></th> --}}
          <th align="left">&nbsp;&nbsp;Date : </th>
          <th align="left">Lead Source: </th>
        </tr>
        <tr>
          <th align="left">&nbsp;&nbsp;Adviser : </th>
          <th align="left">Policy Holder: </th>
        </tr>


      </thead>
      <tbody>
          <h1>{{ $clients[0]->policy_holder }}</h1>

    </tbody>
  </table>
</body>

</html>
<style>
  /*html,
  body {
    min-width: auto;
    background: #EEEEEE;
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 9pt;
    margin: 0;
    box-sizing: content-box;
  }

  table {
    margin: auto;
    border-spacing: 0;
  }*/
</style>