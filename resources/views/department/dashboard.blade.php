@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">{{ $dept->name }} Dashboard</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
        <i class="fas fa-file-pdf me-2"></i>Export Report
    </button>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Complaint Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dept.exportPdf') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="In Process">In Process</option>
                            <option value="Resolved">Resolved</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="date_from" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="date_to" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Download PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Total Complaints -->
    <div class="col-md-4">
        <a href="{{ route('dept.complaints') }}" class="text-decoration-none">
            <div class="card-custom border-bottom border-4 border-primary h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Assigned Complaints</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $totalComplaints }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-25">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Pending -->
    <div class="col-md-4">
        <a href="{{ route('dept.complaints', ['status' => 'Pending']) }}" class="text-decoration-none">
            <div class="card-custom border-bottom border-4 border-warning h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Pending</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $pendingComplaints }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-25">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Resolved -->
    <div class="col-md-4">
        <a href="{{ route('dept.complaints', ['status' => 'Resolved']) }}" class="text-decoration-none">
            <div class="card-custom border-bottom border-4 border-success h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Resolved</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $resolvedComplaints }}</h2>
                    </div>
                    <div class="fs-1 text-success opacity-25">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection