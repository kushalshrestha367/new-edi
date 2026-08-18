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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_code');
            $table->string('patient_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->foreignId('department_has_item_id')->nullable()->constrained('department_has_items')->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('members')->nullOnDelete();
            $table->text('notes')->nullable();

            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('appointments');
    }
};
