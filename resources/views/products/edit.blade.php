@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="d-flex align-items-center mb-4">
        <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'products'])</span>
        <h1 class="display-5 fw-bold mb-0" style="letter-spacing:1px;">Edit Product</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" value="{{ $product->category }}" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                </div>
                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ $product->stock_quantity }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter product description...">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image_url" name="image_url">
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" style="width:80px;height:80px;object-fit:cover;" class="rounded mt-2">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
