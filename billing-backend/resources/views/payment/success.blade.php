<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>

    <!-- Material UI CSS for Styling -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://unpkg.com/@mui/material@5.0.0-beta.5/dist/material-ui.min.js"></script>

    <!-- Custom Styling -->
    <style>
        body {
            background-color: #e8f5e9; /* Light green background */
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .content {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #388e3c; /* Dark green color */
            font-size: 36px;
            margin-bottom: 20px;
        }

        .details {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
            text-align: left;
        }

        .details strong {
            color: #388e3c;
        }

        .gif-container {
            margin-top: 20px;
        }

        .gif-container img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .redirect-message {
            margin-top: 30px;
            font-size: 16px;
            color: #388e3c;
        }

        .MuiButton-root {
            background-color: #388e3c;
            color: white;
            margin-top: 20px;
            border-radius: 20px;
            font-weight: bold;
            padding: 10px 20px;
        }

        .MuiButton-root:hover {
            background-color: #2c6d35;
        }
    </style>

    <script>
        // Redirect to dashboard after 3 seconds
        setTimeout(function () {
            window.location.href = '{{ route("billing_details.index") }}';
        }, 10000);
    </script>
</head>
<body>

    <div class="content">
        <h1>Payment Successful!</h1>

        @if(isset($session))
            <div class="details">
                <p><strong>Payment ID:</strong> {{ \Illuminate\Support\Str::limit($session->id, 40) }}</p>
                <p><strong>Status:</strong> {{ $session->payment_status }}</p>
                <p><strong>Total Amount:</strong> ${{ $session->amount_total / 100 }}</p>
                <p><strong>Currency:</strong> {{ strtoupper($session->currency) }}</p>
                <p><strong>Payment Method:</strong> {{ $session->payment_method_types[0] }}</p>
            </div>
        @else
            <p>Sorry, we couldn't retrieve the payment details.</p>
        @endif

        <div class="gif-container">
            <img src="https://i.pinimg.com/originals/90/13/f7/9013f7b5eb6db0f41f4fd51d989491e7.gif" alt="success gif" />
        </div>

        <div class="redirect-message">
            You will be redirected to your dashboard shortly...
        </div>

        <button class="MuiButton-root">
            Go to Dashboard
        </button>
    </div>

</body>
</html>
