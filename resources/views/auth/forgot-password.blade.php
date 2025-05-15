@extends('layouts.app')
@section('content')
<div class="container my-5 d-flex justify-content-center align-items-center" style="min-height:60vh;">
    <div class="card shadow p-4" style="max-width:400px;width:100%;">
        <div class="d-flex align-items-center mb-4">
            <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'profile'])</span>
            <h1 class="display-5 fw-bold mb-0 text-center w-100" style="letter-spacing:1px;">Forgot Password</h1>
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Email Password Reset Link</button>
        </form>
    </div>
</div>
@endsection
