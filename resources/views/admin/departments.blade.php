@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Managed Departments</h2>
    <div>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addDeptModal">
            <i class="fas fa-plus me-2"></i> Add Department
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- Search Form -->
<form action="{{ route('admin.departments') }}" method="GET" class="mb-4 live-search-form" data-target=".table-responsive">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by Name or Email..." value="{{ request('search') }}">
        <button class="btn btn-primary-custom" type="submit">Search</button>
        <a href="{{ route('admin.departments') }}" class="btn btn-outline-secondary">Clear</a>
    </div>
</form>

<div class="card-custom table-responsive">
    <table class="table table-hover align-middle">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Login (CNIC)</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $dept)
            <tr>
                <td>{{ $dept->id }}</td>
                <td class="fw-bold">{{ $dept->name }}</td>
                <td>{{ $dept->user->cnic ?? 'N/A' }}</td>
                <td>{{ $dept->user->email ?? 'N/A' }}</td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-sm btn-outline-primary me-1" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editModal{{ $dept->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    
                    <!-- Delete Button -->
                    <a href="{{ route('admin.deleteDept', $dept->id) }}" 
                       class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('Are you sure? This will delete the account and all complaints associated.')">
                        <i class="fas fa-trash"></i>
                    </a>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $dept->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.updateDept', $dept->id) }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Department</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Department Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $dept->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">CNIC (Login ID)</label>
                                            <input type="text" name="cnic" class="form-control" value="{{ $dept->user->cnic ?? '' }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $dept->user->email ?? '' }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" value="{{ $dept->user->phone ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
            @empty
                <tr><td colspan="5" class="text-center">No Departments Found</td></tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">
        {{ $departments->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.storeDept') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Health Department" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CNIC (Login ID)</label>
                        <input type="text" name="cnic" class="form-control" placeholder="Unique ID" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" value="password123" required>
                        <small class="text-muted">Default: password123</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create Department</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
