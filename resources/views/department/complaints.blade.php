@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Assigned Complaints</h2>
</div>

<!-- Search & Filter -->
<div class="card-custom mb-4 p-3">
    <form action="{{ route('dept.complaints') }}" method="GET" class="row g-3 live-search-form" data-target=".table-responsive">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search by Citizen or Subject..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Process" {{ request('status') == 'In Process' ? 'selected' : '' }}>In Process</option>
                <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom flex-grow-1">Filter</button>
            <a href="{{ route('dept.complaints') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="card-custom table-responsive">
    <table class="table table-hover align-middle">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Citizen</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
            <tr>
                <td class="fw-bold">{{ $complaint->complaint_id }}</td>
                <td>{{ $complaint->user->name ?? 'Unknown' }}</td>
                <td>{{ Str::limit($complaint->subject, 30) }}</td>
                <td>
                    @if($complaint->status == 'Resolved')
                        <span class="badge bg-success">Resolved</span>
                    @elseif($complaint->status == 'Pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-info">In Process</span>
                    @endif
                </td>
                <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                <td>
                    <!-- View/Update Modal Trigger -->
                    <button class="btn btn-sm btn-primary-custom" data-bs-toggle="modal" data-bs-target="#viewModal{{ $complaint->id }}">
                        Manage
                    </button>

                    <!-- Manager Modal -->
                    <div class="modal fade" id="viewModal{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title">Complaint Details #{{ $complaint->complaint_id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Subject:</strong> {{ $complaint->subject }}</p>
                                            <p><strong>Details:</strong> {{ $complaint->details }}</p>
                                            <p><strong>Address:</strong> {{ $complaint->address }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            @if($complaint->image)
                                                <img src="{{ asset('storage/'.$complaint->image) }}" class="img-fluid rounded mb-3" alt="Evidence">
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <hr>

                                    <!-- Update Status Form -->
                                    <form action="{{ route('dept.updateStatus', $complaint->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Update Status</label>
                                                <select name="status" class="form-select">
                                                    <option value="Pending" {{ $complaint->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In Process" {{ $complaint->status == 'In Process' ? 'selected' : '' }}>In Process</option>
                                                    <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Remarks</label>
                                                <input type="text" name="remarks" class="form-control" value="{{ $complaint->remarks }}" placeholder="Action taken...">
                                            </div>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <button type="submit" class="btn btn-success">Update Status</button>
                                        </div>
                                    </form>
                                    
                                    @if($complaint->feedback)
                                        <div class="alert alert-info mt-3 mb-0">
                                            <strong>Citizen Feedback:</strong> 
                                            {{ $complaint->feedback->rating }} Stars - "{{ $complaint->feedback->comment }}"
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $complaints->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
