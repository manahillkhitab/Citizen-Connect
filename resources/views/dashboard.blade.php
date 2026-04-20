@extends('layouts.app')

@section('content')

<div class="row align-items-center mb-5">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark mb-0">Dashboard Overview</h2>
        <p class="text-muted">Welcome back, {{ Auth::user()->name }}</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('complaints.create') }}" class="btn btn-primary-custom rounded-pill px-4 py-2 shadow-sm">
            <i class="fas fa-plus me-2"></i> File New Complaint
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="row g-4">
    <!-- Total Complaints -->
    <div class="col-md-3">
        <a href="{{ route('complaints.index') }}" class="text-decoration-none">
            <div class="card-custom h-100 border-bottom border-4 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $stats['total'] }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-25">
                        <i class="fas fa-folder-open"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Pending/In Process -->
    <div class="col-md-3">
        <a href="{{ route('complaints.index', ['status' => 'Pending']) }}" class="text-decoration-none">
            <div class="card-custom h-100 border-bottom border-4 border-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Pending</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $stats['pending'] }}</h2>
                    </div>
                    <div class="fs-1 text-warning opacity-25">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Resolved -->
    <div class="col-md-3">
        <a href="{{ route('complaints.index', ['status' => 'Resolved']) }}" class="text-decoration-none">
            <div class="card-custom h-100 border-bottom border-4 border-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Resolved</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $stats['resolved'] }}</h2>
                    </div>
                    <div class="fs-1 text-success opacity-25">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Feedback Given -->
    <div class="col-md-3">
        <div class="card-custom h-100 border-bottom border-4 border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase mb-1">Feedback Given</h6>
                    <h2 class="fw-bold text-dark mb-0">{{ $stats['feedback_given'] }}</h2>
                </div>
                <div class="fs-1 text-info opacity-25">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection