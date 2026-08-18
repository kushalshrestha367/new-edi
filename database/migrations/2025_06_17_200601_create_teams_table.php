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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('academic')->nullable();
            $table->text('message')->nullable();
            $table->longText('bio')->nullable();
            $table->string('image_path')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('address')->nullable();
            
            $table->boolean('has_message')->default(false);
            $table->boolean('on_menu')->default(false);
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
        Schema::dropIfExists('teams');
    }
};
