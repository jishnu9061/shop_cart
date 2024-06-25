<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <header>
        <a href="#" class="logo"><img src="{{ asset('images/image/logo.png') }}" alt=""></a>
        <ul class="navmenu">

            @auth('web')
                <li><a href="{{ route('user.product.index') }}">Products</a></li>
                <li><a class="" href="{{ route('user.logout') }}"
                        onclick="event.preventDefault();if(confirm('Are you sure you want to logout?')) document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <li><a href="{{ route('register') }}">Register</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
        </ul>
        <div class="nav-icon">
        </div>
    </header>
    <section class="main-home">
        <div class="main-text">
            <h5>Winter Collection</h5>
            <h1>New Winter <br> Collection</h1>
            <p>There's Nothing like Trend</p>
            <a href="#" class="main-btn">Shop Now<i class="bx bx-right-arrow-alt"></i></a>
        </div>
        <div class="down-arrow">
            <a href="#trending" class="down"><i class="bx bx-down-arrow-alt"></i></a>
        </div>
    </section>
    <section class="trending-product" id="trending">
        <div class="center-text">
            <h2>Our Trending <span>Products</span></h2>
        </div>
        <div class="products">
            <!-- Update each product row -->
            <div class="row">
                @foreach ($products as $product)
                <img src="{{ ProductHelper::getProductImagePath($product->file_name) }}" alt="">
                <div class="product-text">
                    <h5>Sale</h5>
                    <div class="price">
                        <h4>{{ $product->name }}</h4>
                        <p>{{ $product->price }}</p>
                    </div>
                    <!-- Add button to add to cart -->
                    <button class="add-to-cart-btn main-btn" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}">Add to Cart</button>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="cart">
        <a href="{{ route('cart.index') }}">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-counter">0</span>
        </a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('stick.js') }}"></script>
    <script src="{{ asset('cart.js') }}"></script>
    <script>
        // cart.js

        $(document).ready(function() {
            $('.add-to-cart-btn').click(function() {
                var productId = $(this).data('id');
                var productName = $(this).data('name');
                var productPrice = parseFloat($(this).data('price'));

                $.ajax({
                    url: "/add-to-cart", // Laravel named route for adding to cart
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
                    },
                    data: {
                        id: productId,
                        name: productName,
                        price: productPrice
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Product added to cart!');
                            updateCartCounter(response
                                .totalQuantity); // Update cart counter in UI
                        } else {
                            alert('Failed to add product to cart.');
                        }
                    },
                    error: function() {
                        alert('Failed to add product to cart.');
                    }
                });
            });

            // Function to update the cart counter in the UI
            function updateCartCounter(quantity) {
                $('.cart-counter').text(quantity); // Update the cart counter text
            }
        });
    </script>
</body>

</html>
