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
        Schema::create('program_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_category_id')->constrained('program_categories')->onDelete('cascade');
            $table->string('slug');
            $table->string('title');
            $table->string('short_form',15)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('program_lists');
    }
};
