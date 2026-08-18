<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->integer('vacancies')->default(1);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('salary')->nullable();
            $table->json('experience')->nullable();
            $table->date('deadline')->nullable();
            $table->string('mail_on')->nullable();
            $table->boolean('need_mail')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
