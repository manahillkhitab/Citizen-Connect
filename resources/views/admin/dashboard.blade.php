@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Admin Dashboard</h2>
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
            <form action="{{ route('admin.exportPdf') }}" method="GET" target="_blank">
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
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">All Departments</option>
                            @foreach($deptStats as $dept)
                                <option value="{{ \App\Models\Department::where('name', $dept->name)->first()->id ?? '' }}">{{ $dept->name }}</option>
                            @endforeach
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
    <!-- Total Citizens -->
    <div class="col-md-4">
        <div class="card-custom border-bottom border-4 border-primary h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase mb-1">Total Citizens</h6>
                    <h2 class="fw-bold text-dark mb-0">{{ $totalCitizens }}</h2>
                </div>
                <div class="fs-1 text-primary opacity-25">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Departments -->
    <div class="col-md-4">
         <a href="{{ route('admin.departments') }}" class="text-decoration-none">
            <div class="card-custom border-bottom border-4 border-success h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Departments</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $totalDepts }}</h2>
                        <small class="text-success fw-bold">Click to Manage</small>
                    </div>
                    <div class="fs-1 text-success opacity-25">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
         </a>
    </div>

    <!-- Total Complaints -->
    <div class="col-md-4">
        <a href="{{ route('admin.complaints') }}" class="text-decoration-none">
            <div class="card-custom border-bottom border-4 border-warning h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mb-1">Total Complaints</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $totalComplaints }}</h2>
                        <small class="text-warning fw-bold">Click to View</small>
                    </div>
                    <div class="fs-1 text-warning opacity-25">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Separator -->

<!-- Combined Row: Charts & Table -->
<div class="row mt-3 g-3">
    
    <!-- Col 1: Status Pie Chart -->
    <div class="col-md-3">
        <div class="card-custom h-100 py-2 text-center">
            <h6 class="fw-bold mb-1 small text-uppercase">Status</h6>
            <div style="height: 180px; position: relative;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Col 2: Dept Bar Chart -->
    <div class="col-md-5">
        <div class="card-custom h-100 py-2 text-center">
            <h6 class="fw-bold mb-1 small text-uppercase">Dept Workload</h6>
            <div style="height: 180px; position: relative;">
                <canvas id="deptChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Col 3: Dept Detailed Stats (Table) -->
    <div class="col-md-4">
        <div class="card-custom h-100 py-2 px-2">
            <h6 class="fw-bold mb-2 small text-uppercase text-center">Dept Details</h6>
            <div class="table-responsive" style="height: 180px; overflow-y: auto;">
                <table class="table table-sm table-hover text-xs mb-0" style="font-size: 0.8rem;">
                    <thead class="sticky-top bg-white">
                        <tr>
                            <th>Dept</th>
                            <th class="text-center">Tot</th>
                            <th class="text-center">Res</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deptStats as $stat)
                        @php $pct = $stat->total > 0 ? round(($stat->resolved / $stat->total) * 100) : 0; @endphp
                        <tr>
                            <td class="text-truncate" style="max-width: 80px;" title="{{ $stat->name }}">{{ $stat->name }}</td>
                            <td class="text-center fw-bold">{{ $stat->total }}</td>
                            <td class="text-center text-success">{{ $stat->resolved }}</td>
                            <td style="width: 30%;">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-success" style="width:{{$pct}}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data from Controller
        const deptNames = @json($deptNames);
        const deptCounts = @json($deptCounts);
        const statusData = @json($statusCounts);

        // Common Options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false, // Important for fixed height
        };

        // 1. Status Pie Chart
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In Process', 'Resolved'],
                datasets: [{
                    data: [statusData['Pending'], statusData['In Process'], statusData['Resolved']],
                    backgroundColor: ['#ffc107', '#0dcaf0', '#198754'],
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });

        // 2. Department Bar Chart
        const ctxDept = document.getElementById('deptChart').getContext('2d');
        new Chart(ctxDept, {
            type: 'bar',
            data: {
                labels: deptNames,
                datasets: [{
                    label: 'Total Complaints',
                    data: deptCounts,
                    backgroundColor: '#0d6efd',
                    borderRadius: 5
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>

@endsection