@extends('layouts.app')
@section('content')
<div class="container my-4">
    <h1 class="mb-4" style="font-weight:600;letter-spacing:1px;">Submit Event/Salon Image</h1>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="card p-4 shadow-sm" id="eventForm">
        @csrf
        <div class="alert alert-info" id="imageSizeAlert" style="display:none;">Image must be 2MB or less.</div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Image <span class="text-muted" style="font-size:0.95em;">(Max 2MB, jpeg/png/jpg/gif)</span></label>
            <input type="file" name="image" class="form-control" accept="image/*" required id="eventImageInput">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('eventImageInput').addEventListener('change', function() {
    const alertDiv = document.getElementById('imageSizeAlert');
    if (this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
        alertDiv.style.display = 'block';
        this.value = '';
    } else {
        alertDiv.style.display = 'none';
    }
});
</script>
@endpush
