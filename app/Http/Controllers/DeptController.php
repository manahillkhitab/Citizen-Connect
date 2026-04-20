<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class DeptController extends Controller
{
    public function index()
    {
        // 1. Get the Department ID linked to the logged-in User
        $dept = Department::where('user_id', Auth::id())->first();

        // 2. Get Stats for THIS Department only
        $totalComplaints = Complaint::where('department_id', $dept->id)->count();
        $pendingComplaints = Complaint::where('department_id', $dept->id)->where('status', 'Pending')->count();
        $resolvedComplaints = Complaint::where('department_id', $dept->id)->where('status', 'Resolved')->count();
        
        // Pass dept ID to view for links
        return view('department.dashboard', compact('dept', 'totalComplaints', 'pendingComplaints', 'resolvedComplaints'));
    }

    // Show Complaints Assigned to Dept
    public function complaints(Request $request)
    {
        $dept = Department::where('user_id', Auth::id())->first();
        
        $query = Complaint::where('department_id', $dept->id);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%$search%");
                  });
            });
        }

        if($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10);
        $categories = Category::where('department_id', $dept->id)->get(); 

        return view('department.complaints', compact('complaints', 'categories'));
    }

    // Show Categories Management Page
    public function categories(Request $request)
    {
        $dept = Department::where('user_id', Auth::id())->first();
        $query = Category::where('department_id', $dept->id);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->get();
        return view('department.categories', compact('categories'));
    }

    // Add a New Category (e.g. Theft, Potholes)
    public function storeCat(Request $request)
    {
        $request->validate(['name' => 'required']);
        
        $dept = Department::where('user_id', Auth::id())->first();

        Category::create([
            'department_id' => $dept->id,
            'name' => $request->name
        ]);

        return back()->with('success', 'Category Added Successfully');
    }

    // Update Category
    public function updateCat(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return back()->with('success', 'Category Updated Successfully');
    }

    // Delete Category
    public function deleteCat($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category Deleted Successfully');
    }

    // Update Complaint Status
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        
        $complaint->status = $request->status;
        $complaint->remarks = $request->remarks;
        $complaint->save();

        return back()->with('success', 'Complaint Status Updated');
    }
    // Export Complaints as PDF
    public function exportPdf(Request $request)
    {
        $dept = Department::where('user_id', Auth::id())->first();
        $query = Complaint::where('department_id', $dept->id)->with('category');

        // Filter Logic
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
        $deptName = $dept->name;

        // Return view directly for browser printing (bypassing dependency issues)
        return view('department.pdf_report', compact('complaints', 'deptName'));
    }
}