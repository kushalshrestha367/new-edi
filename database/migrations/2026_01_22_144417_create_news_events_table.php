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
        Schema::create('news_events', function (Blueprint $table) {
            $table->id();

            // Distinguish News / Event
            $table->enum('type', ['news', 'event'])->index();

            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');

            // Media
            $table->json('image_path')->nullable();

            // Event-specific fields
            $table->dateTime('event_start_date')->nullable();
            $table->dateTime('event_end_date')->nullable();
            $table->string('event_location')->nullable();

            // UI flags (optional but useful)
            $table->boolean('is_popup')->default(false)->index();
            $table->boolean('is_scroll')->default(false)->index();

            // Sorting
            $table->integer('sort_order')->default(0)->index();

            // Publishing
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();

            // Author
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Performance indexes
            $table->index(['type', 'is_published']);
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_events');
    }
};
