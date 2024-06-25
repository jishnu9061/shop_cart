<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        /* Your existing CSS styles */
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            /* Hidden by default */
            justify-content: center;
            align-items: center;
        }

        .cart {
            background: #fff;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            text-align: center;
            border-radius: 8px;
        }

        .cart h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .cart-content {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .cart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px; /* Added margin top for spacing */
        }

        .close-cart {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <!-- Your header content here if applicable -->
    </header>
    <div class="cart-page">
        <h1>Shopping Cart</h1>
        <div class="cart-items">
            @foreach ($cartItems as $item)
                <div class="cart-item">
                    <img src="" alt="">
                    <div>
                        <h4>{{ $item['name'] }}</h4>
                        <h5>${{ $item['price'] }}</h5>
                        <p>Quantity: {{ $item['quantity'] }}</p>
                        <!-- Display subtotal for each item -->
                        <p>Subtotal: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-footer">
            <!-- Display total price -->
            <h3>Total: ${{ number_format($totalPrice, 2) }}</h3> <!-- Assuming $totalPrice is calculated in your controller -->
            <!-- Add checkout button or other actions as needed -->
        </div>
    </div>
    <script src="{{ asset('stick.js') }}"></script> <!-- Include your JavaScript file if needed -->
</body>

</html>
