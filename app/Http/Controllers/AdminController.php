<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Complaint;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. Show the Admin Dashboard (Stats Only)
    public function index()
    {
        // Get Stats for the Cards
        $totalCitizens = User::where('role', 'citizen')->count();
        $totalDepts = Department::count();
        $totalComplaints = Complaint::count();

        // New: Department-wise Stats
        $deptStats = Department::withCount([
            'complaints as total',
            'complaints as pending' => function ($query) {
                $query->where('status', 'Pending');
            },
            'complaints as resolved' => function ($query) {
                $query->where('status', 'Resolved');
            }
        ])->get();

        // CHART DATA PREPARATION
        
        // 1. Department Chart Data
        $deptNames = $deptStats->pluck('name')->toArray();
        $deptCounts = $deptStats->pluck('total')->toArray();

        // 2. Status Chart Data
        $statusCounts = [
            'Pending' => Complaint::where('status', 'Pending')->count(),
            'In Process' => Complaint::where('status', 'In Process')->count(),
            'Resolved' => Complaint::where('status', 'Resolved')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalCitizens', 
            'totalDepts', 
            'totalComplaints', 
            'deptStats',
            'deptNames',
            'deptCounts',
            'statusCounts'
        ));
    }

    // 1.5 Show Departments List (Searchable)
    public function departments(Request $request)
    {
        $query = Department::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('email', 'like', "%$search%");
                  });
        }

        $departments = $query->paginate(10);
        return view('admin.departments', compact('departments'));
    }

    // 1.6 Show All Complaints List (Searchable + Filterable)
    public function complaints(Request $request)
    {
        $query = Complaint::with(['user', 'department', 'category']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  })
                  ->orWhereHas('department', function($d) use ($search) {
                      $d->where('name', 'like', "%$search%");
                  });
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10);
        return view('admin.complaints', compact('complaints'));
    }

    // 2. Store a New Department
    public function storeDept(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'cnic' => 'required|unique:users,cnic', // Using CNIC as unique ID for Dept Login
            'phone' => 'required'
        ]);

        // A. Create the User Account for the Department
        $user = User::create([
            'name' => $request->name, // e.g. "Police Department"
            'email' => $request->email,
            'cnic' => $request->cnic,
            'phone' => $request->phone,
            'role' => 'department',   // IMPORTANT: Role is 'department'
            'password' => Hash::make($request->password),
        ]);

        // B. Create the Department Entry linked to that User
        Department::create([
            'name' => $request->name,
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Department Added Successfully!');
    }
    // 3. Update Department (Edit)
    public function updateDept(Request $request, $id)
    {
        $dept = Department::findOrFail($id);
        $user = User::findOrFail($dept->user_id);

        // Validate
        $request->validate([
            'name' => 'required',
            'cnic' => 'required|unique:users,cnic,'.$user->id, // Allow keeping same CNIC
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required'
        ]);

        // Update User Account
        $user->update([
            'name' => $request->name,
            'cnic' => $request->cnic,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update Department Table
        $dept->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Department Updated Successfully!');
    }

    // 4. Delete Department
    public function deleteDept($id)
    {
        $dept = Department::findOrFail($id);
        $user = User::findOrFail($dept->user_id);

        // Deleting the User will automatically delete the Dept
        // because we set onDelete('cascade') in migrations
        $user->delete();

        return back()->with('success', 'Department Deleted Successfully!');
    }
    // 5. Export Complaints as PDF
    public function exportPdf(Request $request)
    {
        $query = Complaint::with(['user', 'department']);

        // Filter Logic
        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->latest()->get();

        // Get Department Name for Report Header if filtered
        $filters = [];
        if($request->department_id) {
            $filters['department_name'] = Department::find($request->department_id)->name ?? 'Unknown';
        }

        // Return view directly for browser printing (bypassing dependency issues)
        return view('admin.pdf_report', compact('complaints', 'filters'));
    }
}