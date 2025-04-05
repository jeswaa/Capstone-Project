@section('content')
<div class="container">
    <h1>Settings</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="admin_email" class="form-label">Admin Email</label>
            <input type="email" class="form-control" id="admin_email" name="admin_email" value="{{ old('admin_email', $adminEmail) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Email</button>
    </form>
</div>
@endsection