<!-- resources/views/success.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
    <h1>Payment Successful!</h1>

    @if(isset($session))
        <p><strong>Payment ID:</strong> {{ $session->id }}</p>
        <p><strong>Status:</strong> {{ $session->payment_status }}</p>
        <p><strong>Total Amount:</strong> ${{ $session->amount_total / 100 }}</p>
        <p><strong>Currency:</strong> {{ strtoupper($session->currency) }}</p>
        <p><strong>Payment Method:</strong> {{ $session->payment_method_types[0] }}</p>
        
        <!-- You can display more details depending on what you want -->
        <p><strong>Customer Email:</strong> {{ $session->customer_email }}</p>
    @else
        <p>Sorry, we couldn't retrieve the payment details.</p>
    @endif
</body>
</html>
