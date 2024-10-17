@extends('layouts.customer.master')

@section('content')

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5"
    style="position: relative; overflow: hidden; background: url('{{ asset('storage/img/cart-header-bg.jpg') }}') no-repeat center center; background-size: cover;">
    <div style="background: rgba(0, 0, 0, 0.096); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 1;">
    </div>
    <h1 class="text-center display-6 text-dark" style="position: relative; z-index: 2;">{{ __('cart.page_title') }}</h1>
    <ol class="breadcrumb justify-content-center mb-0" style="position: relative; z-index: 2;">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">{{ __('cart.breadcrumb_home') }}</a></li>
        <li class="breadcrumb-item active text-primary">{{ __('cart.breadcrumb_cart') }}</li>
    </ol>
</div>
<!-- Single Page Header End -->



<div class="container-fluid py-5">
    <div class="container">
        @if($cartItems->isEmpty())
        <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
            <div class="alert alert-warning text-center">
                {!! __('cart.empty_cart', ['link' => route('home')]) !!}
            </div>
        </div>
        @else
            <div class="table-responsive">
                <table class="table" id="cart-table">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">{{ __('cart.products') }}</th>
                            <th scope="col">{{ __('cart.name') }}</th>
                            <th scope="col">{{ __('cart.price') }}</th>
                            <th scope="col">{{ __('cart.quantity') }}</th>
                            <th scope="col">{{ __('cart.total') }}</th>
                            <th scope="col">{{ __('cart.handle') }}</th>
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
                            <small class="text-muted">* {{ __('cart.ppn_included') }}</small>
                        </div>

                        <!-- Form to handle checkout -->
                        @php
                        $userAddress = \App\Models\UserAddress::where('user_id', auth()->id())->where('is_active', true)->first();
                    @endphp
                    @if($userAddress)
                    <!-- Form to handle checkout -->
                    <form action="{{ route('customer.checkout') }}" method="POST">
                        @csrf
                        <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="submit">{{ __('cart.checkout') }}</button>
                    </form>
                    @else
                    <div class="alert alert-warning text-center">
                        {{ __('cart.address_warning') }}
                    </div>
                    @endif
                    
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
