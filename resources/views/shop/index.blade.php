@extends('layouts.app')
@section('content')
<div class="container my-4">
    <h1 class="mb-4">Shop</h1>
    <form method="GET" action="{{ route('shop') }}" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="category" class="col-form-label">Category:</label>
            </div>
            <div class="col-auto">
                <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" @if(request('category') == $cat) selected @endif>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col ms-auto">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Search</button>
            </div>
        </div>
    </form>

    @if($bestSellers && count($bestSellers))
        <h2 class="mb-3">Best Sellers This Month</h2>
        <!-- Carousel for small screens -->
        <div class="d-block d-md-none mb-4">
            <div id="bestSellersCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php $i = 0; @endphp
                    @foreach($bestSellers as $category => $product)
                        <div class="carousel-item @if($i === 0) active @endif">
                            <div class="card border-success mx-auto" style="max-width: 320px;">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height:140px;object-fit:cover;">
                                @else
                                    <img src="{{ asset('placeholder.svg') }}" class="card-img-top" alt="No image" style="height:140px;object-fit:cover;opacity:0.7;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title text-success">{{ $category }}</h6>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <div class="small">Sold: {{ $product->total_sold }}</div>
                                </div>
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bestSellersCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bestSellersCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!-- Grid for md+ screens -->
        <div class="row mb-4 d-none d-md-flex">
            @foreach($bestSellers as $category => $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card border-success h-100">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height:120px;object-fit:cover;">
                        @else
                            <img src="{{ asset('placeholder.svg') }}" class="card-img-top" alt="No image" style="height:120px;object-fit:cover;opacity:0.7;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title text-success">{{ $category }}</h6>
                            <div class="fw-bold">{{ $product->name }}</div>
                            <div class="small">Sold: {{ $product->total_sold }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row">
        @foreach($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height:150px;object-fit:cover;">
                    @else
                        <img src="{{ asset('placeholder.svg') }}" class="card-img-top" alt="No image" style="height:150px;object-fit:cover;opacity:0.7;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-1">{{ $product->category }}</p>
                        <p class="card-text fw-bold mb-2">${{ $product->price }}</p>
                        <div class="d-flex gap-2 mt-auto">
                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm" style="max-width:70px;">
                                    <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                                </div>
                            </form>
                            <button class="btn btn-outline-secondary btn-sm quick-view-btn" data-product-id="{{ $product->id }}" type="button">Quick View</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($products as $product)
    loadReviews({{ $product->id }});
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
                document.querySelector('#reviews-' + productId + ' .reviews-list').innerHTML = html;
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

    // AJAX Add to Cart
    document.querySelectorAll('form[action*="cart.add"]').forEach(form => {
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
                let msg = data.success ? 'Added to cart!' : (data.error || 'Error adding to cart.');
                alert(msg);
                // Removed red dot logic
            });
        });
    });

    // Quick View Modal logic
    document.querySelectorAll('.quick-view-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            fetch(`/products/${productId}`)
                .then(res => res.json())
                .then(product => {
                    document.getElementById('quickViewTitle').textContent = product.name;
                    document.getElementById('quickViewImage').src = product.image_url || '/placeholder.svg';
                    document.getElementById('quickViewImage').alt = product.name;
                    document.getElementById('quickViewCategory').textContent = product.category;
                    document.getElementById('quickViewPrice').textContent = `$${product.price}`;
                    document.getElementById('quickViewDescription').textContent = product.description || '';
                    const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                    modal.show();
                });
        });
    });
});
</script>
@endpush

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quickViewTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="quickViewImage" src="" alt="" class="img-fluid mb-3 rounded" style="max-height:220px;object-fit:cover;">
        <div class="mb-2"><span class="badge bg-secondary" id="quickViewCategory"></span></div>
        <div class="mb-2 fw-bold" id="quickViewPrice"></div>
        <div class="mb-2" id="quickViewDescription"></div>
      </div>
    </div>
  </div>
</div>
