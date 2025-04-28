<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled</title>
</head>
<body>
    <h1>Payment Cancelled</h1>

    <!-- Display the error message if available -->
    @if (isset($error_message))
        <p>Error: {{ $error_message }}</p>
    @else
        <p>Your payment has been cancelled. Please try again.</p>
    @endif
</body>
</html>
