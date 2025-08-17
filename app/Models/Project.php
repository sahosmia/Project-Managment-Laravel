<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'academic_year',
        'course_title',
        'course_code',
        'problem_statement',
        'motivation',
        'course_type',
        'semester',
        'status',
        'created_by',
        'department_id',
        'r_cell_id',
        'supervisor_id',
        'cosupervisor_id',
    ];

    public function rcell()
    {
        return $this->belongsTo(RCell::class, 'r_cell_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
    public function cosupervisor()
    {
        return $this->belongsTo(User::class, 'cosupervisor_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'student_id');
    }


    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'pending_research_cell':
            case 'pending_admin':
            case 'pending_supervisor':
                return 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-500';
            case 'completed':
                return 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500';
            case 'rejected_research_cell':
            case 'rejected_admin':
            case 'rejected_supervisor':
                return 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-500';
            default:
                return 'bg-gray-50 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400';
        }
    }
}
