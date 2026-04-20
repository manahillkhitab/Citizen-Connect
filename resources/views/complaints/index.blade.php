@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">My Complaints</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
    </a>
    </a>
</div>

<!-- Search & Filter Form -->
<div class="card-custom mb-4 p-3">
    <form action="{{ route('complaints.index') }}" method="GET" class="row g-3 live-search-form" data-target=".table-responsive">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search by Subject..." value="{{ request('search') }}">
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
            <a href="{{ route('complaints.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>

<div class="card-custom">
    @if($complaints->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
            <p class="text-muted">No complaints found.</p>
            <a href="{{ route('complaints.create') }}" class="btn btn-primary-custom mt-2">File a Complaint</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3">ID</th>
                        <th class="py-3">Subject</th>
                        <th class="py-3">Department</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Date</th>
                        <th class="py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($complaints as $complaint)
                    <tr>
                        <td class="fw-bold text-primary">{{ $complaint->complaint_id }}</td>
                        <td>{{ Str::limit($complaint->subject, 40) }}</td>
                        <td><span class="badge bg-secondary rounded-pill fw-normal">{{ $complaint->department->name ?? 'N/A' }}</span></td>
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
                            <div class="d-flex gap-2">
                                <!-- View Details Button -->
                                <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#viewModal{{ $complaint->id }}">
                                    <i class="fas fa-eye"></i> View
                                </button>

                                <!-- Feedback Logic -->
                                @if($complaint->status == 'Resolved')
                                    @if($complaint->feedback)
                                        <button class="btn btn-sm btn-success disabled" title="Feedback Given">
                                            <i class="fas fa-star"></i> Rated
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $complaint->id }}">
                                            <i class="fas fa-star"></i> Feedback
                                        </button>
                                    @endif
                                @else
                                    <!-- <button class="btn btn-sm btn-light text-muted" disabled>Wait</button> -->
                                @endif
                            </div>

                            <!-- View Details Modal -->
                            <div class="modal fade" id="viewModal{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">Complaint #{{ $complaint->complaint_id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <h6 class="fw-bold text-primary">{{ $complaint->subject }}</h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-calendar-alt me-1"></i> {{ $complaint->created_at->format('d M, Y h:i A') }}
                                                        <span class="mx-2">|</span>
                                                        <span class="badge bg-secondary">{{ $complaint->category->name ?? 'General' }}</span>
                                                    </p>
                                                    <hr>
                                                    <p><strong>Description:</strong></p>
                                                    <p class="bg-light p-3 rounded">{{ $complaint->details }}</p>
                                                    
                                                    <p><strong>Location:</strong> {{ $complaint->address }}</p>

                                                    @if($complaint->remarks)
                                                        <div class="alert alert-info mt-3">
                                                            <strong>Department Remarks:</strong> {{ $complaint->remarks }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="fw-bold mb-2">Attachment</label>
                                                    @if($complaint->image)
                                                        <img src="{{ asset('storage/'.$complaint->image) }}" class="img-fluid rounded border shadow-sm" alt="Evidence">
                                                    @else
                                                        <div class="alert alert-secondary text-center py-4">No Image Attached</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Feedback Modal (Moved inside conditional to keep clean, or kept separate if needed) -->
                            @if($complaint->status == 'Resolved' && !$complaint->feedback)
                            <div class="modal fade" id="feedbackModal{{ $complaint->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('feedback.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="complaint_id" value="{{ $complaint->id }}">
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rate Resolution</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Rating (1-5)</label>
                                                    <select name="rating" class="form-select" required>
                                                        <option value="5">5 - Excellent</option>
                                                        <option value="4">4 - Good</option>
                                                        <option value="3">3 - Average</option>
                                                        <option value="2">2 - Poor</option>
                                                        <option value="1">1 - Very Poor</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Comments</label>
                                                    <textarea name="comment" class="form-control" rows="3" placeholder="Any comments..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit Feedback</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $complaints->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
