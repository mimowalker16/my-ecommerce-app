@extends('layouts.app')
@section('content')
<div class="container my-4">
    <div class="d-flex align-items-center mb-4">
        <span class="me-3" style="display:inline-block;vertical-align:middle;">@include('partials.nav-icons', ['icon' => 'events'])</span>
        <h1 class="display-5 fw-bold mb-0" style="letter-spacing:1px;">Event Gallery</h1>
    </div>
    @if($events->isEmpty())
        <div class="alert alert-info">No approved events yet.</div>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($event->image_url)
                            <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="card-img-top" style="height:140px;object-fit:cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:140px;">
                                <span class="text-muted">No image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text text-muted mb-1">{{ $event->event_date }}</p>
                            <p class="card-text">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
