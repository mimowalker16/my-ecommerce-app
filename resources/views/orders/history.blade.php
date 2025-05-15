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
                                                    <span class="star-input d-inline-flex">
                                                        @for($i=1;$i<=5;$i++)
                                                            <input type="radio" name="rating" id="star-{{ $item->product_id }}-{{ $i }}" value="{{ $i }}" style="display:none;" />
                                                            <label for="star-{{ $item->product_id }}-{{ $i }}" class="star-label" style="cursor:pointer;font-size:1.5rem;color:#e4e5e9;">
                                                                &#9733;
                                                            </label>
                                                        @endfor
                                                    </span>
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
<style>
.star-label.selected,
.star-label:hover,
.star-label:hover ~ .star-label {
    color: #FFD600 !important;
}
.star-input input[type="radio"]:checked ~ label {
    color: #FFD600 !important;
}
</style>
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
                        html += `<div class="d-flex align-items-center mb-1">
                            <span class="star-rating me-2">${renderStars(r.rating)}</span>
                            <span>${r.comment ? r.comment : ''}</span>
                        </div>`;
                    });
                    if (data.reviews.length > 0) {
                        const lastReview = data.reviews[data.reviews.length - 1];
                        html += `<div class="d-flex align-items-center mb-1">
                            <span class="star-rating me-2">${renderStars(lastReview.rating)}</span>
                            <span>${lastReview.comment ? lastReview.comment : ''}</span>
                        </div>`;
                    }
                }
                document.querySelectorAll('#reviews-' + productId + ' .reviews-list').forEach(function(el) {
                    el.innerHTML = html;
                });
            });
    }

    function renderStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += `<svg width="18" height="18" fill="#FFD600" viewBox="0 0 24 24" style="vertical-align:middle;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>`;
            } else {
                stars += `<svg width="18" height="18" fill="#e4e5e9" viewBox="0 0 24 24" style="vertical-align:middle;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>`;
            }
        }
        return stars;
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

    document.querySelectorAll('.star-input').forEach(function(starInput) {
        const stars = starInput.querySelectorAll('.star-label');
        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', function() {
                for(let i=0; i<=idx; i++) stars[i].style.color = '#FFD600';
                for(let i=idx+1; i<stars.length; i++) stars[i].style.color = '#e4e5e9';
            });
            star.addEventListener('mouseleave', function() {
                const checked = starInput.querySelector('input[type="radio"]:checked');
                let val = checked ? parseInt(checked.value) : 0;
                stars.forEach((s, i) => s.style.color = i < val ? '#FFD600' : '#e4e5e9');
            });
            star.addEventListener('click', function() {
                starInput.querySelectorAll('input[type="radio"]')[idx].checked = true;
                stars.forEach((s, i) => s.style.color = i <= idx ? '#FFD600' : '#e4e5e9');
            });
        });
    });
});
</script>
@endpush
