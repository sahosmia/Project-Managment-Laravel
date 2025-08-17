<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // To prevent data loss, we'll first update the existing records to use the new status values.
        DB::table('projects')->where('status', 'rejected_by_research_cell')->update(['status' => 'rejected_research_cell']);
        DB::table('projects')->where('status', 'rejected_by_admin')->update(['status' => 'rejected_admin']);
        DB::table('projects')->where('status', 'rejected_by_supervisor')->update(['status' => 'rejected_supervisor']);

        // Then, we alter the table to use the new enum values.
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', [
                'pending_research_cell',
                'rejected_research_cell',
                'pending_admin',
                'rejected_admin',
                'pending_supervisor',
                'rejected_supervisor',
                'completed'
            ])->default('pending_research_cell')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // To prevent data loss, we'll first update the existing records to use the old status values.
        DB::table('projects')->where('status', 'rejected_research_cell')->update(['status' => 'rejected_by_research_cell']);
        DB::table('projects')->where('status', 'rejected_admin')->update(['status' => 'rejected_by_admin']);
        DB::table('projects')->where('status', 'rejected_supervisor')->update(['status' => 'rejected_by_supervisor']);

        // Then, we alter the table to use the old enum values.
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', [
                'pending_research_cell',
                'rejected_by_research_cell',
                'pending_admin',
                'rejected_by_admin',
                'pending_supervisor',
                'rejected_by_supervisor',
                'completed'
            ])->default('pending_research_cell')->change();
        });
    }
};
