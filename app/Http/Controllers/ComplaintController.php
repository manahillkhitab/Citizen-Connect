<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // 0. List User Complaints (Paginated)
    // List User's Complaints (Paginated + Search/Filter)
    public function index(Request $request)
    {
        $query = Complaint::where('user_id', Auth::id());

        // Search by Subject
        if ($request->has('search') && $request->search != '') {
            $query->where('subject', 'like', '%' . $request->search . '%');
        }

        // Filter by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10);
        return view('complaints.index', compact('complaints'));
    }

    // 1. Show the File Complaint Form
    public function create()
    {
        $departments = Department::all();
        return view('complaints.create', compact('departments'));
    }

    // 2. AJAX: Get Categories for a selected Department
    public function getCategories($id)
    {
        $categories = Category::where('department_id', $id)->pluck('name', 'id');
        return response()->json($categories);
    }

    // 3. Store the Complaint
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'category_id' => 'required',
            'subject' => 'required',
            'details' => 'required',
            'address' => 'required',
            'image' => 'nullable|image|max:2048' // Max 2MB
        ]);

        // Generate Custom Complaint ID (e.g., COMP001)
        $lastComplaint = Complaint::latest()->first();
        $nextId = $lastComplaint ? $lastComplaint->id + 1 : 1;
        $customId = 'COMP' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaints', 'public');
        }

        Complaint::create([
            'complaint_id' => $customId,
            'user_id' => Auth::id(),
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'subject' => $request->subject,
            'details' => $request->details,
            'address' => $request->address,
            'image' => $imagePath,
            'status' => 'Pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Complaint Registered Successfully! Ticket ID: ' . $customId);
    }
}