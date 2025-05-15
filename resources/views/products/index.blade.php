@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="d-flex align-items-center mb-4">
        <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'products'])</span>
        <h1 class="display-5 fw-bold mb-0" style="letter-spacing:1px;">Product Management</h1>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add New Product</a>
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0" style="font-size:1.2rem; font-weight:600;">Products</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" style="width:50px;height:50px;object-fit:cover;" class="rounded">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td class="d-flex flex-column flex-md-row gap-1">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary btn-sm w-100 w-md-auto">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline w-100 w-md-auto" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 w-md-auto">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
