@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4">Edit User</h4>

  <!-- User Information Update Form -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Edit User Details</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
          <label for="type" class="form-label">Role</label>
          <select class="form-control" id="type" name="type">
            <option value="customer" {{ $user->type == 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User Info</button>
      </form>
    </div>
  </div>

  <!-- Password Update Form -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Change Password</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.users.updatePassword', $user->id) }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="password" class="form-label">New Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm New Password</label>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-warning">Change Password</button>
      </form>
    </div>
  </div>
</div>

@endsection
