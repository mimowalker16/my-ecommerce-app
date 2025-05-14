@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold mb-3" style="color:#F53003; letter-spacing:1px;">Welcome to My E-commerce</h1>
            <p class="lead text-muted mb-4">Discover the best products, exclusive deals, and a seamless shopping experience inspired by the Laracom style. Shop with confidence and enjoy fast delivery, secure checkout, and top-rated customer support.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-4 me-2" style="background:#F53003; border:none; font-weight:600;">Shop Now</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg px-4">Register</a>
            @endguest
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{ asset('hero.jpg') }}" alt="Shop Hero" class="img-fluid rounded shadow" style="max-height:340px; object-fit:cover;">
        </div>
    </div>
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-truck display-5 text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Fast Delivery</h5>
                    <p class="card-text text-muted">Get your orders delivered quickly and reliably, every time.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-shield-check display-5 text-success mb-3"></i>
                    <h5 class="card-title fw-bold">Secure Checkout</h5>
                    <p class="card-text text-muted">Your payment and personal information are always safe with us.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-star-fill display-5 text-warning mb-3"></i>
                    <h5 class="card-title fw-bold">Top Rated Support</h5>
                    <p class="card-text text-muted">Our team is here to help you with any questions or issues.</p>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4 fw-bold" style="color:#F53003;">Featured Products</h2>
    <div class="row">
        @foreach($featuredProducts ?? [] as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 border-primary">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height:150px;object-fit:cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:150px;">
                            <span class="text-muted">No image</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-1">{{ $product->category }}</p>
                        <p class="card-text fw-bold mb-2">${{ $product->price }}</p>
                        <a href="{{ route('shop') }}" class="btn btn-outline-primary mt-auto">View Shop</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if(empty($featuredProducts) || count($featuredProducts) == 0)
            <div class="col-12">
                <div class="alert alert-info text-center">Check out our full selection in the <a href="{{ route('shop') }}">Shop</a>!</div>
            </div>
        @endif
    </div>
</div>
@endsection
