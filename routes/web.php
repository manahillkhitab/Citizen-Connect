<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeptController;
use App\Http\Controllers\ComplaintController;
use App\Models\Complaint; // Needed to fetch complaints for dashboard
use App\Models\Feedback;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page
Route::get('/', function () {
    return view('landing');
});

// Route to fetch categories (Accessed via JavaScript AJAX)
// Placed outside auth so it's easily accessible, or keep it here.
Route::get('/get-categories/{id}', [ComplaintController::class, 'getCategories']);


// ---------------------------------------------------------------------
// GUEST ROUTES (Login & Register)
// ---------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// ---------------------------------------------------------------------
// AUTHENTICATED ROUTES (Grouped by Role)
// ---------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // Global Logout (Accessible by all roles)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==========================================
    // 1. ADMIN DASHBOARD (Only Admin)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Departments CRUD
        Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin.departments'); // [NEW] List View
        Route::get('/admin/complaints', [AdminController::class, 'complaints'])->name('admin.complaints'); // [NEW] List View

        Route::post('/admin/add-department', [AdminController::class, 'storeDept'])->name('admin.storeDept');
        Route::post('/admin/department/update/{id}', [AdminController::class, 'updateDept'])->name('admin.updateDept');
        Route::get('/admin/department/delete/{id}', [AdminController::class, 'deleteDept'])->name('admin.deleteDept');
        
        // Export PDF
        Route::get('/admin/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.exportPdf');
    });

    // ==========================================
    // 2. DEPARTMENT DASHBOARD (Only Dept)
    // ==========================================
    Route::middleware('role:department')->group(function () {
        // Dashboard
        Route::get('/department/dashboard', [DeptController::class, 'index'])->name('department.dashboard');
        Route::get('/department/complaints', [DeptController::class, 'complaints'])->name('dept.complaints'); // [NEW] List View
        Route::get('/department/categories', [DeptController::class, 'categories'])->name('dept.categories'); // [NEW] Categories View
        
        // Actions
        Route::post('/department/add-category', [DeptController::class, 'storeCat'])->name('dept.storeCat');
        Route::post('/department/category/update/{id}', [DeptController::class, 'updateCat'])->name('dept.updateCat');
        Route::get('/department/complaint/delete/{id}', [DeptController::class, 'deleteCat'])->name('dept.deleteCat');

        Route::post('/department/complaint/update/{id}', [DeptController::class, 'updateStatus'])->name('dept.updateStatus');
        
        // Export PDF
        Route::get('/department/export-pdf', [DeptController::class, 'exportPdf'])->name('dept.exportPdf');
    });

    // ==========================================
    // 3. CITIZEN DASHBOARD (Only Citizen)
    // ==========================================
    Route::middleware('role:citizen')->group(function () {
        
        // Main Dashboard (Stats Only)
        Route::get('/dashboard', function () {
            $userId = Auth::id();
            $myComplaints = Complaint::where('user_id', $userId)->get();
            
            // Calculate Stats
            $stats = [
                'total' => $myComplaints->count(),
                'pending' => $myComplaints->whereIn('status', ['Pending', 'In Process'])->count(),
                'resolved' => $myComplaints->where('status', 'Resolved')->count(),
                'feedback_given' => Feedback::where('user_id', $userId)->count(),
            ];

            return view('dashboard', compact('stats'));
        })->name('dashboard');
        
        // Complaint Routes
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index'); // Paginated List
        Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
        Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store');

        // Feedback Routes
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

        // Profile Routes (Citizen)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

});