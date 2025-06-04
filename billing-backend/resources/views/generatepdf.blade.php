<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
  <title>Invoice</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      
    }

    body {
      padding: 40px 50px 50px 50px;
      background: #fff;
      color: #000;
      box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
    }

    h1 {
      font-size: 1.5rem;
      letter-spacing: 0.2rem;
      text-align: center;
      text-transform: uppercase;
      background: #000;
      color: #fff;
      padding: 10px;
      border-radius: 0.25em;
      margin-bottom: 20px;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 2em;
    }

    header address {
      font-size: 0.9rem;
      line-height: 1.5;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2em;
      font-size: 0.85rem;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      width: 160px;
    }

    th {
      background: #eee;
      text-align: left;
    }

    .meta,
    .balance {
      width: 40%;
      float: right;
    }

    .inventory {
      clear: both;
    }

    .inventory th,
    .inventory td {
      text-align: center;
    }

    @media print {
      body {
        box-shadow: none;
        margin: 0;
        padding: 0.5in;
      }

      header input {
        display: none;
      }
    }
  </style>
</head>
<body>

  <h1>Billing Invoice</h1>

  <header>
    <address>
        <p>Occupant Name: {{ $first_name  . " " . $last_name ?? 'N/A' }}</p>
        <p>Bunglaw No: {{  $hno }} {{  $area }}</p>
        <p>Last Payment Date: {{ $last_pay_date ?? 'N/A' }}</p>
    </address>
  </header>

  <article>
    <table class="meta">
      <tr>
        <th>Invoice #</th>
        <td>{{ uniqid('INV-') }}</td>
      </tr>
      <tr>
        <th>Invoice Date</th>
        <td>{{ now()->format('d F Y') }}</td>
      </tr>
    </table>

    <table class="inventory">
      <thead>
        <tr>
          <th>Bill Detail</th>
          <th>Reading</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Last Reading</td>
          <td>{{ $last_reading }}</td>
        </tr>
        <tr>
          <td>Current Reading</td>
          <td>{{ $current_reading }}</td>
        </tr>
        <tr>
          <td>Total Units</td>
          <td>{{ $total_units }}</td>
        </tr>
        <tr>
          <td>Remission</td>
          <td>{{ $remission }}</td>
        </tr>
        <tr>
          <td>Units After Remission</td>
          <td>{{ $unit_after_remission }}</td>
        </tr>
        <tr>
          <td>Current Charges</td>
          <td>Rs.{{ number_format($current_charges, 2) }} Per Unit</td>
        </tr>
        <tr>
          <td>Outstanding Dues</td>
          <td>Rs.{{ number_format($outstanding_dues, 2) }}</td>
        </tr>
        @php
            $totalAmount = 0;
            $totalSum = 0;
            $grossTotal = 0;
            $grossTotal = $totalSum + $outstanding_dues + $totalAmount;
        @endphp
        @foreach ($taxes as $tax)
        @php
        $totalAmount += $tax['amount'];
        @endphp
        <tr>
          <td>{{ $tax['name'] }} ({{ $tax['percentage'] }}%)</td>
          <td>Rs.{{ number_format($tax['amount'], 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @php
    $sum = $current_reading - $remission;
    $totalSum = $sum * $current_charges;
    @endphp
    <table class="balance">
      <tr>
        <th>Current Total (without Tax)</th>
        <td>Rs.{{ number_format($totalSum, 2) }}</td>
      </tr>
      <tr>
        <th>Outstanding</th>
        <td>Rs.{{ number_format($outstanding_dues, 2) }}</td>
      </tr>
      <tr>
        <th>Charges</th>
        <td>Rs.{{ number_format($totalAmount, 2) }}</td>
      </tr>
      @php
      $grossTotal = 0;
      $grossTotal = $totalSum + $outstanding_dues + $totalAmount;
     @endphp
      <tr>
        <th>Gross Total</th>
        <td>Rs.{{ number_format($grossTotal, 2) }}</td>
      </tr>
      <tr>
        <th>Status</th>
        <td>UNPAID</td>
      </tr>
    </table>
  </article>

</body>
</html>
