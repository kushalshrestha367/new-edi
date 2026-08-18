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
        Schema::create('about_has_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_us_id')->constrained('about_us')->cascadeOnDelete(); // Link to the AboutUs page
            $table->string('title');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0); // For ordering achievements if needed

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_has_achievements');
    }
};
