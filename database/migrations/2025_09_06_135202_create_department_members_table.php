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
        Schema::create('department_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_has_item_id')->nullable()->constrained('department_has_items')->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            
            $table->boolean('show_first')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->nullable();

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
        Schema::dropIfExists('department_members');
    }
};
