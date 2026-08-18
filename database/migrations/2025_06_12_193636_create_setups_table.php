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
        Schema::create('setups', function (Blueprint $table) {
            $table->id();
            $table->string('site_tagline')->nullable();
            $table->string('primary_color')->default('#000'); 
            $table->string('secondary_color')->nullable();
            $table->string('light_color')->nullable();
            $table->string('dark_color')->nullable();
            $table->text('footer_text')->nullable();
            $table->boolean('maintenance_mode')->default(false);
            $table->string('site_theme')->default('Starter');

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
        Schema::dropIfExists('setups');
    }
};
