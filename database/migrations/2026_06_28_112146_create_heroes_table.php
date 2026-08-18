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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('institution_short_name')->nullable();
            $table->text('description')->nullable();

            $table->string('cta_label')->default('Know More');
            $table->string('cta_url')->default('/about');

            $table->boolean('show_video_button')->default(true);
            $table->string('video_url')->nullable();
            $table->string('video_title')->default('Campus Tour');

            $table->string('bg_image_left')->nullable();
            $table->string('bg_image_right')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

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
        Schema::dropIfExists('heroes');
    }
};
