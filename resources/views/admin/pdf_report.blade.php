<!DOCTYPE html>
<html>
<head>
    <title>Complaint Report</title>
    <title>Complaint Report</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats { margin-bottom: 20px; display: flex; gap: 20px; flex-wrap: wrap; }
        .stats div { font-weight: bold; background: #f8f9fa; padding: 5px 10px; border-radius: 4px; border: 1px solid #dee2e6; }
        .badge { padding: 4px 8px; border-radius: 4px; color: white; font-size: 10px; display: inline-block; }
        .badge-pending { background-color: #ffc107; color: black; }
        .badge-in-process { background-color: #0dcaf0; }
        .badge-resolved { background-color: #198754; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
    <script>
        window.onload = function() { window.print(); }
    </script>
</head>
<body>
    <div class="header">
        <h2>Citizen Connect - Complaint Report</h2>
        <p>Generated on: {{ date('Y-m-d H:i') }}</p>
    </div>

    <div class="stats">
        <div>Total Complaints: {{ $complaints->count() }}</div>
        @if(request('status'))
            <div>Filter Status: {{ request('status') }}</div>
        @endif
        @if(request('department_id'))
            <div>Filter Department: {{ $filters['department_name'] ?? 'All' }}</div>
        @endif
        @if(request('date_from'))
            <div>Date From: {{ request('date_from') }}</div>
        @endif
        @if(request('date_to'))
            <div>Date To: {{ request('date_to') }}</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Subject</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
            <tr>
                <td>#{{ $complaint->id }}</td>
                <td>{{ $complaint->created_at->format('Y-m-d') }}</td>
                <td>{{ $complaint->subject }}</td>
                <td>{{ $complaint->department->name ?? 'N/A' }}</td>
                <td>
                    @if($complaint->status == 'Pending')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($complaint->status == 'In Process')
                        <span class="badge badge-in-process">In Process</span>
                    @else
                        <span class="badge badge-resolved">Resolved</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
