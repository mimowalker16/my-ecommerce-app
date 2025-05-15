@extends('layouts.app')
@section('content')
<div class="container my-5 d-flex justify-content-center align-items-center" style="min-height:60vh;">
    <div class="card shadow p-4" style="max-width:400px;width:100%;">
        <div class="d-flex align-items-center mb-4">
            <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'profile'])</span>
            <h1 class="display-5 fw-bold mb-0 text-center w-100" style="letter-spacing:1px;">Login</h1>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
        </form>
    </div>
</div>
@endsection
