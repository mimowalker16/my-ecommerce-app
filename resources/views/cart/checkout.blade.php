@extends('layouts.app')
@section('content')
<div class="container my-4">
    <h1 class="mb-4" style="font-weight:600;letter-spacing:1px;">Checkout</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($cartItems->isEmpty())
        <div class="alert alert-info">Your cart is empty. There is nothing to checkout.</div>
        <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0" style="font-size:1.2rem; font-weight:600;">Order Summary</h2>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        @if($item->product->image_url)
                                            <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" style="width:50px;height:50px;object-fit:cover;" class="rounded">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($item->product->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-end mb-4">
                    <h3 class="fw-bold">Total: ${{ number_format($total, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h2 class="mb-0" style="font-size:1.1rem; font-weight:600;">Shipping & Payment</h2>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-2">Shipping Address</h5>
                        <p>{{ Auth::user()->name ?? Auth::user()->first_name }}</p>
                        <p>{{ Auth::user()->email }}</p>
                        <hr>
                        <h5 class="mb-2">Payment Method</h5>
                        <p><em>(Payment integration will be implemented here)</em></p>
                        <form method="POST" action="{{ route('cart.placeOrder') }}">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Place Order</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">&laquo; Back to Cart</a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX Place Order (optional enhancement)
    const checkoutForm = document.querySelector('form[action*="cart.placeOrder"]');
    if(checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                let msg = data.success ? 'Order placed!' : (data.error || 'Error placing order.');
                alert(msg);
                if(data.success && data.redirect) window.location.href = data.redirect;
            });
        });
    }
});
</script>
@endpush
