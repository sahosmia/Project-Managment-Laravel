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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('academic_year')->nullable();
            $table->string('course_title')->nullable();
            $table->string('course_code')->nullable();
            $table->longText('problem_statement')->nullable();
            $table->longText('motivation')->nullable();
            $table->text('notes')->nullable();

            $table->enum('course_type', ['project', 'thesis'])->default('project');
            $table->enum('semester', ['fall', 'summer', 'spring'])->nullable();
            $table->enum('status', ['pending_research_cell', 'rejected_research_cell', 'pending_admin', 'rejected_admin', 'pending_supervisor', 'rejected_supervisor', 'completed'])->default('pending_admin');

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('r_cell_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('cosupervisor_id')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('r_cell_id')->references('id')->on('r_cells')->onDelete('set null');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cosupervisor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
