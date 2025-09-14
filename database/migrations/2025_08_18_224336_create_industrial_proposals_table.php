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
        Schema::create('industrial_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('skills');
            $table->string('industrial_supervisor_name')->nullable();
            $table->string('industrial_supervisor_phone')->nullable();
            $table->string('industrial_supervisor_email')->nullable();
            $table->string('company')->nullable();
            // $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'inprogress', 'complete'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_proposals');
    }
};
