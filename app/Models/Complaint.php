<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id', 'user_id', 'department_id', 'category_id',
        'subject', 'details', 'address', 'image', 'status', 'remarks'
    ];

    // Belongs to the Citizen
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Belongs to a Dept
    public function department() {
        return $this->belongsTo(Department::class);
    }

    // Belongs to a Category
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Has one Feedback
    public function feedback() {
        return $this->hasOne(Feedback::class);
    }
}