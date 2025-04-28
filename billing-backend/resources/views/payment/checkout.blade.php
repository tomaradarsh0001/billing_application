<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
</head>
<body>

<h1>Pay for Your Order</h1>

<form action="{{ route('create.checkout.session') }}" method="POST">
    @csrf
    <button type="submit">Pay with Stripe</button>
</form>

<script src="https://js.stripe.com/v3/"></script>
</body>
</html>
