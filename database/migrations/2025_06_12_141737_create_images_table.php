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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->char('uuid',100)
                ->unique();
            $table->string('disk');
            $table->string('mime_type');
            $table->string('file_extension');
            $table->unsignedInteger('width');
            $table->unsignedInteger('height');
            $table->unsignedInteger('size');
            $table->json('title')
                ->nullable();
            $table->json('alt')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
