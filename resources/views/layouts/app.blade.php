<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Laracom/Bootstrap style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --my-yellow: #ffe000;
            --my-black: #000000;
            --my-white: #ffffff;
        }
        body {
            background: var(--my-yellow) !important;
            color: var(--my-black) !important;
        }
        .navbar, footer {
            background: var(--my-black) !important;
            color: var(--my-white) !important;
        }
        .navbar .navbar-brand, .navbar .nav-link, .navbar .nav-link.active, .navbar .nav-link:focus, .navbar .nav-link:hover {
            color: var(--my-white) !important;
        }
        .main-content, .table, .form-control {
            background: var(--my-yellow) !important;
            color: var(--my-black) !important;
        }
        .card, .modal-content {
            background: transparent !important;
            color: var(--my-black) !important;
            border: 2px solid var(--my-black) !important;
            box-shadow: 0 2px 8px 0 rgba(0,0,0,0.13), 0 1.5px 4px 0 rgba(0,0,0,0.10) !important;
        }
        .btn, .btn-primary, .btn-dark, .btn-danger, .btn-success, .btn-secondary {
            background: var(--my-black) !important;
            color: var(--my-white) !important;
            border: none !important;
        }
        .btn-outline-primary, .btn-outline-secondary, .btn-outline-success, .btn-outline-danger {
            background: transparent !important;
            color: var(--my-black) !important;
            border: 2px solid var(--my-black) !important;
        }
        input, textarea, select {
            background: var(--my-yellow) !important;
            color: var(--my-black) !important;
            border: 1px solid var(--my-black) !important;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--my-black) !important;
            box-shadow: 0 0 0 2px var(--my-yellow) !important;
        }
        .bg-dark, .bg-primary, .bg-secondary, .bg-success, .bg-warning, .bg-info, .bg-danger {
            background: var(--my-black) !important;
            color: var(--my-white) !important;
        }
        .text-dark, .text-primary, .text-secondary, .text-success, .text-warning, .text-info, .text-danger {
            color: var(--my-black) !important;
        }
        .text-white, .navbar-dark .navbar-nav .nav-link {
            color: var(--my-white) !important;
        }
        .card-title, .fw-bold, h1, h2, h3, h4, h5, h6, label, .form-label {
            color: var(--my-black) !important;
        }
        .alert {
            background: var(--my-yellow) !important;
            color: var(--my-black) !important;
            border: 1px solid var(--my-black) !important;
        }
        .modal-header, .modal-footer {
            background: var(--my-black) !important;
            color: var(--my-white) !important;
        }
        .modal-title {
            color: var(--my-white) !important;
        }
        .modal-content {
            border: 2px solid var(--my-black) !important;
        }
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f8f9fa; }
        .navbar-brand { font-weight: 700; letter-spacing: 2px; }
        .nav-link, .navbar-nav .nav-link { font-weight: 500; letter-spacing: 1px; }
        .main-content { min-height: 80vh; }
        footer { background: #343a40; color: #fff; padding: 24px 0; text-align: center; margin-top: 40px; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">My E-commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/">@include('partials.nav-icons', ['icon' => 'home'])</a></li>
                <li class="nav-item"><a class="nav-link" href="/shop">@include('partials.nav-icons', ['icon' => 'shop'])</a></li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="/admin">@include('partials.nav-icons', ['icon' => 'admin'])</a></li>
                        <li class="nav-item"><a class="nav-link" href="/products">@include('partials.nav-icons', ['icon' => 'products'])</a></li>
                        <li class="nav-item"><a class="nav-link" href="/events/pending">@include('partials.nav-icons', ['icon' => 'events'])</a></li>
                    @endif
                    @if(auth()->user()->isIt())
                        <li class="nav-item"><a class="nav-link" href="/it">@include('partials.nav-icons', ['icon' => 'admin'])</a></li>
                        <li class="nav-item"><a class="nav-link" href="/products">@include('partials.nav-icons', ['icon' => 'products'])</a></li>
                        <li class="nav-item"><a class="nav-link" href="/events">@include('partials.nav-icons', ['icon' => 'events'])</a></li>
                        <li class="nav-item"><a class="nav-link" href="/events/create">@include('partials.nav-icons', ['icon' => 'events'])</a></li>
                    @endif
                    @if(auth()->user()->isClient())
                        <li class="nav-item"><a class="nav-link" href="/orders/history">@include('partials.nav-icons', ['icon' => 'orders'])</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="/events/gallery">@include('partials.nav-icons', ['icon' => 'events'])</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cart">@include('partials.nav-icons', ['icon' => 'cart'])</a></li>
                    <li class="nav-item"><a class="nav-link" href="/profile">@include('partials.nav-icons', ['icon' => 'profile'])</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="display:inline; padding:0;">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="main-content">
    @isset($header)
        <header class="bg-white shadow-sm mb-4">
            <div class="container py-4">
                {{ $header }}
            </div>
        </header>
    @endisset
    <main class="container">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
</div>
<footer>
    <div class="container">
        &copy; {{ date('Y') }} My E-commerce. All rights reserved.
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
