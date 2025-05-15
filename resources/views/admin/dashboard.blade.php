@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="d-flex align-items-center mb-4">
        <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'admin'])</span>
        <h1 class="display-5 fw-bold mb-0" style="letter-spacing:1px;">Admin Dashboard</h1>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none;">
                <div class="card-body text-white">
                    <h5 class="card-title" style="font-weight: 500;">Total Sales</h5>
                    <p class="card-text display-6" style="font-weight: 700;">{{ $totalSales }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border: none;">
                <div class="card-body text-white">
                    <h5 class="card-title" style="font-weight: 500;">Total Revenue</h5>
                    <p class="card-text display-6" style="font-weight: 700;">${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #36b9cc 0%, #258fa3 100%); border: none;">
                <div class="card-body text-white">
                    <h5 class="card-title" style="font-weight: 500;">Orders This Month</h5>
                    <p class="card-text display-6" style="font-weight: 700;">{{ $ordersThisMonth }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm" style="background: linear-gradient(135deg, #858796 0%, #343a40 100%); border: none;">
                <div class="card-body text-white">
                    <h5 class="card-title" style="font-weight: 500;">Total Users</h5>
                    <p class="card-text display-6" style="font-weight: 700;">{{ $userCount }}</p>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary mb-4" style="font-weight:500; letter-spacing:1px;">Manage Users</a>
    <div class="card shadow mb-4">
        <div class="card-header" style="background: #343a40; color: #fff; border-bottom: 2px solid #4e73df;">
            <h2 class="mb-0" style="font-size:1.3rem; font-weight:600; letter-spacing:1px;">Top 5 Products (All Time)</h2>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0" style="font-size:1.05rem;">
                <thead style="background: #f8f9fc;">
                    <tr>
                        <th style="color:#4e73df; font-weight:600;">Product</th>
                        <th style="color:#1cc88a; font-weight:600;">Sold</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($topProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sold }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
