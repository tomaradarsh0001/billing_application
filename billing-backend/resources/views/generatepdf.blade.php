<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <style>
    /* Your existing styles stay unchanged */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      padding-right: 50px;
      padding-left: 50px;
      padding-bottom: 50px;
      padding-top: 40px;
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
      width: 160px
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
        <p>Occupant Name: {{ $house_id }}</p>
        <p>Bunglaw No. {{ $occupant_id }}</p>
        <p>Contact No. {{ $last_pay_date }}</p>
      </address>
  </header>

  <article>
    <table class="meta">
      <tr>
        <th>Invoice #</th>
        <td>{{ uniqid('INV-') }}</td>
      </tr>
      <tr>
        <th>Date</th>
        <td>{{ now()->format('d F Y') }}</td>
      </tr>
      <tr>
        <th>Amount Due</th>
        <td>₹{{ number_format($total_amount_with_tax, 2) }}</td>
      </tr>
    </table>

    <table class="inventory">
      <thead>
        <tr>
          <th>Item</th>
          <th>Details</th>
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
          <td>₹{{ number_format($current_charges, 2) }}</td>
        </tr>
        <tr>
          <td>Outstanding Dues</td>
          <td>₹{{ number_format($outstanding_dues, 2) }}</td>
        </tr>
        @foreach ($taxation as $tax)
        <tr>
          <td>{{ $tax->tax_name }}</td>
          <td>₹{{ number_format($tax->tax_amount, 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <table class="balance">
      <tr>
        <th>Total Amount (with Tax)</th>
        <td>₹{{ number_format($total_amount_with_tax, 2) }}</td>
      </tr>
      <tr>
        <th>Amount Paid</th>
        <td>₹0.00</td>
      </tr>
      <tr>
        <th>Balance Due</th>
        <td>₹{{ number_format($total_amount_with_tax, 2) }}</td>
      </tr>
    </table>
  </article>

</body>
</html>
