@extends('layouts.customer.master')

@section('content')

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        @if($cartItems->isEmpty())
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="alert alert-warning text-center">
                Keranjang anda kosong, silahkan berbelanja <a href="{{ route('home') }}" class="text-primary">di sini</a>.
            </div>
        </div>
        @else
            <div class="table-responsive">
                <table class="table" id="cart-table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $cartItem)
                        <tr id="cart-item-{{ $cartItem->id }}">
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset(optional($cartItem->product->images->first())->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px; object-fit: cover" alt="{{ $cartItem->product->name }}">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">{{ $cartItem->product->name }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4" id="price-{{ $cartItem->id }}">
                                    @if ($cartItem->product->discount_price)
                                        <span class="text-muted text-decoration-line-through">
                                            Rp{{ number_format($cartItem->product->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-danger">
                                            Rp{{ number_format($cartItem->product->discount_price, 0, ',', '.') }}
                                        </span>
                                    @else
                                        Rp{{ number_format($cartItem->product->price, 0, ',', '.') }}
                                    @endif
                                </p>
                            </td>
                            
                                                    
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-id="{{ $cartItem->id }}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" id="quantity-{{ $cartItem->id }}" value="{{ $cartItem->quantity }}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-id="{{ $cartItem->id }}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4" id="total-{{ $cartItem->id }}">Rp{{ number_format($cartItem->total_price, 0, ',', '.') }}</p>
                            </td>
                            
                            <td>
                                <button class="btn btn-md rounded-circle bg-light border mt-4 remove-from-cart" data-id="{{ $cartItem->id }}" type="button">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Checkout Button in Blade Template -->
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="py-4 border-top border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4" id="cart-total">Rp{{ number_format($total, 0, ',', '.') }}</p> <!-- Total ID for dynamic update -->
                            </div>
                        </div>
                        <!-- Notification for PPN inclusion -->
                        <div class="text-end pe-4 mb-3">
                            <small class="text-muted">* Harga Total Sudah Termasuk PPN</small>
                        </div>

                        <!-- Form to handle checkout -->
                        <form action="{{ route('customer.checkout') }}" method="POST">
                            @csrf
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="submit">Proceed Checkout</button>
                        </form>
                    </div>
                </div>
            </div>

            
            
            
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the click event for removing a cart item
        document.querySelectorAll('.remove-from-cart').forEach(function(button) {
            button.addEventListener('click', function() {
                var cartItemId = this.getAttribute('data-id');
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send AJAX request to remove the item
                fetch('/customer/cart/remove/' + cartItemId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        _token: token,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the item row from the table
                        document.getElementById('cart-item-' + cartItemId).remove();

                        // Update the subtotal and total values
                        document.getElementById('cart-subtotal').innerText = '$' + data.newSubtotal.toFixed(2);
                        document.getElementById('cart-total').innerText = '$' + data.newTotal.toFixed(2);
                    } else {
                        console.error('Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Function to handle quantity update
    function updateQuantity(cartItemId, action) {
        var quantityInput = document.getElementById('quantity-' + cartItemId);
        var currentQuantity = parseInt(quantityInput.value);
        var newQuantity = action === 'increase' ? currentQuantity + 1 : currentQuantity - 1;

        // Ensure the quantity cannot be less than 1
        if (newQuantity < 1) {
            newQuantity = 1;
        }

        // Update input value
        quantityInput.value = newQuantity;

        // Send AJAX request to update quantity
        fetch('/customer/cart/update/' + cartItemId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the total price for the product
                document.getElementById('total-' + cartItemId).innerText = 'Rp' + new Intl.NumberFormat('id-ID').format(data.newProductTotal);

                // Update the overall cart total
                document.getElementById('cart-total').innerText = 'Rp' + new Intl.NumberFormat('id-ID').format(data.newCartTotal);
            } else {
                console.error('Failed to update quantity');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.querySelectorAll('.btn-plus').forEach(function(button) {
    var newButton = button.cloneNode(true); // Clone the button to remove all event listeners
    button.parentNode.replaceChild(newButton, button); // Replace the button with the cloned version
    newButton.addEventListener('click', function(e) {
        e.stopImmediatePropagation();
        var cartItemId = this.getAttribute('data-id');
        updateQuantity(cartItemId, 'increase');
    });
});

document.querySelectorAll('.btn-minus').forEach(function(button) {
    var newButton = button.cloneNode(true); // Clone the button to remove all event listeners
    button.parentNode.replaceChild(newButton, button); // Replace the button with the cloned version
    newButton.addEventListener('click', function(e) {
        e.stopImmediatePropagation();
        var cartItemId = this.getAttribute('data-id');
        updateQuantity(cartItemId, 'decrease');
    });
});

});



</script>
@endsection
