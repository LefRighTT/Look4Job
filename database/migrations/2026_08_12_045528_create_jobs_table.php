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
    Schema::create('job_listings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->string('location');
        $table->decimal('salary', 10, 2)->nullable();
        $table->string('experience_level')->nullable();
        $table->string('education_level')->nullable();
        $table->string('skills')->nullable();
        $table->string('benefits')->nullable();
        $table->enum('remote_option', ['all options','remote', 'on-site', 'hybrid'])->default('all options');
        $table->enum('job_type', ['full-time', 'part-time', 'contract', 'internship']);
        $table->date('application_deadline')->nullable();
        $table->string('company_name');
        $table->string('company_website')->nullable();
        $table->enum('status', ['open', 'closed'])->default('open');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('job_listings');
    }
};
