@extends('layouts.app')
@section('content')
<div class="container my-4">
    <h1 class="mb-4" style="font-weight:600;letter-spacing:1px;">Your Cart</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($cartItems->isEmpty())
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    @else
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0" style="font-size:1.2rem; font-weight:600;">Cart Items</h2>
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
                            <th>Actions</th>
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
                            <td>
                                <form method="POST" action="{{ route('cart.update', $item->product_id) }}" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width:70px;">
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $item->product_id) }}" onsubmit="return confirm('Remove this item?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Total: ${{ number_format($total, 2) }}</h3>
            <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg">Proceed to Checkout</a>
        </div>
        <a href="{{ route('shop') }}" class="btn btn-outline-primary">Continue Shopping</a>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX Update Cart
    document.querySelectorAll('form[action*="cart.update"]').forEach(form => {
        form.addEventListener('submit', function(e) {
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
                let msg = data.success ? 'Cart updated!' : (data.error || 'Error updating cart.');
                alert(msg);
                if(data.success) location.reload();
            });
        });
    });
    // AJAX Remove from Cart
    document.querySelectorAll('form[action*="cart.remove"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if(!confirm('Remove this item?')) return;
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
                let msg = data.success ? 'Item removed!' : (data.error || 'Error removing item.');
                alert(msg);
                if(data.success) location.reload();
            });
        });
    });
});
</script>
@endpush
