<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        
        // The Custom ID (e.g., COMP001)
        $table->string('complaint_id')->unique(); 
        
        // The Citizen who filed it
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Which Department handles it
        $table->foreignId('department_id')->constrained()->onDelete('cascade');
        
        // What Category it falls under
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        // Complaint Details
        $table->string('subject');
        $table->text('details');
        $table->text('address');
        $table->string('image')->nullable(); // Optional photo
        
        // Status tracking
        $table->string('status')->default('Pending'); // Default is Pending
        
        // Department's reply/remarks
        $table->text('remarks')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
