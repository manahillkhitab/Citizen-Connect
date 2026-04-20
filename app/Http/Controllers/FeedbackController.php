<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'complaint_id' => 'required|exists:complaints,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $complaint = Complaint::findOrFail($request->complaint_id);

        // Ensure user owns the complaint
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Ensure not already feedbacked? (Optional, but good logic)
        // Ensure status is resolved?
        if ($complaint->status !== 'Resolved') {
             return back()->with('error', 'You can only provide feedback for resolved complaints.');
        }

        Feedback::create([
            'user_id' => Auth::id(),
            'complaint_id' => $complaint->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
