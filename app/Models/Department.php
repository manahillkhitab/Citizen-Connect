<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Link to the User Account (Login info for this dept)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // A Dept has many Categories (e.g., Police has Theft, Harassment)
    public function categories() {
        return $this->hasMany(Category::class);
    }

    // A Dept receives many Complaints
    public function complaints() {
        return $this->hasMany(Complaint::class);
    }
}