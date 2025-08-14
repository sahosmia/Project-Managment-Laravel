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

  
}
