@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="d-flex align-items-center mb-4">
        <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'orders'])</span>
        <h1 class="display-5 fw-bold mb-0" style="letter-spacing:1px;">Order History</h1>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($orders->isEmpty())
        <div class="alert alert-info">You have no orders yet.</div>
    @else
        @foreach($orders as $order)
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order #{{ $order->id }} | Date: {{ $order->order_date }} | Total: ${{ $order->total_amount }}</h5>
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
                        @foreach($orderItems->where('order_id', $order->id) as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>@if($item->image_url)<img src="{{ $item->image_url }}" style="width:50px;height:50px;object-fit:cover;" class="rounded">@endif</td>
                                <td>${{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ $item->price * $item->quantity }}</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="reviews" id="reviews-{{ $item->product_id }}-order-{{ $order->id }}">
                                        <strong>Reviews:</strong>
                                        <div class="reviews-list"></div>
                                        @auth
                                            <form class="review-form" data-product="{{ $item->product_id }}">
                                                <label>Rating:
                                                    <select name="rating" required>
                                                        <option value="">-</option>
                                                        @for($i=1;$i<=5;$i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </label>
                                                <br>
                                                <label>Comment:
                                                    <input type="text" name="comment" maxlength="1000">
                                                </label>
                                                <button type="submit">Submit Review</button>
                                            </form>
                                            <div class="review-message" style="color:green;"></div>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($orders as $order)
        @foreach($orderItems->where('order_id', $order->id) as $item)
            loadReviews({{ $item->product_id }});
        @endforeach
    @endforeach

    function loadReviews(productId) {
        fetch('/products/' + productId + '/reviews')
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data.reviews.length === 0) {
                    html = '<em>No reviews yet.</em>';
                } else {
                    data.reviews.forEach(r => {
                        html += `<div><b>${r.rating}/5</b> - ${r.comment ? r.comment : ''}</div>`;
                    });
                }
                document.querySelectorAll('#reviews-' + productId + ' .reviews-list').forEach(function(el) {
                    el.innerHTML = html;
                });
            });
    }

    document.querySelectorAll('.review-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product');
            const formData = new FormData(this);
            fetch('/products/' + productId + '/review', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                let msgDiv = this.parentElement.querySelector('.review-message');
                if (data.success) {
                    msgDiv.textContent = 'Review submitted!';
                    loadReviews(productId);
                    this.reset();
                } else {
                    msgDiv.textContent = data.error || 'Error submitting review.';
                    msgDiv.style.color = 'red';
                }
            });
        });
    });
});
</script>
@endpush
