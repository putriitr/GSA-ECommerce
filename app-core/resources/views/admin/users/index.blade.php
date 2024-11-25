@extends('layouts.admin.master')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

  <!-- Success message -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Error messages -->
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- User List Card -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-2">List of Users</h5>
      <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex mb-2">
        <div class="input-group">
            <input type="text" name="search" class="form-control me-2" placeholder="Search user..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary me-2">
                <i class="fas fa-search"></i> Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync-alt"></i> Refresh
                </a>
            @endif
        </div>
    </form>
    
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $index => $user)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->phone }}</td>
              <td>{{ $user->type === 'admin' ? 'Admin' : 'Customer' }}</td>
              <td>
                <!-- Edit button -->
                <a class="btn btn-sm btn-primary" href="{{ route('admin.users.edit', $user->id) }}">
                  <i class="bx bx-edit-alt"></i> Edit
                </a>

                <!-- Delete button -->
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                    <i class="bx bx-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-center mt-5 mb-2">
      {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
  </div>
  </div>
</div>

@endsection
