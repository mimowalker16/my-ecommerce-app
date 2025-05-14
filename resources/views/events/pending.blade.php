@extends('layouts.app')
@section('content')
<div class="container my-4">
    <h1 class="mb-4" style="font-weight:600;letter-spacing:1px;">Pending Events (Admin Approval)</h1>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($events->isEmpty())
        <div class="alert alert-info">No pending events.</div>
    @else
        <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>@if($event->image_url)<img src="{{ $event->image_url }}" class="rounded" style="width:80px;height:60px;object-fit:cover;">@else<span class="text-muted">No image</span>@endif</td>
                    <td>
                        <form method="POST" action="{{ route('events.approve', $event->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('events.reject', $event->id) }}" class="d-inline ms-1">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    @endif
</div>
@endsection
