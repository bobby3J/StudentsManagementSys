@extends('layout.master')
@section('content')
<div class="container">
    <h1>User Details</h1>

    <div class="card">
        <div class="card-header">
            {{ $user->fullname }}
        </div>
        <div class="card-body">
            <p><strong>Full Name:</strong> {{ $user->fullname }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Created At:</strong> {{ $user->created_at->format('d M Y') }}</p>
            <p><strong>Updated At:</strong> {{ $user->updated_at->format('d M Y') }}</p>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Back to List</a>
</div>
@endsection
