<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'parent_id',
        'student_id',
        'phone',
        'r_cell_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Created by student
     public function createdProjects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    // Project assign of supervisor
    public function supervisedProjects()
    {
        return $this->hasMany(Project::class, 'supervisor_id');
    }

    // Member of project
    public function memberOfProjects()
    {
        return $this->belongsToMany(Project::class, 'project_members', 'student_id', 'project_id');
    }

      public function industrialProposals()
    {
        return $this->hasMany(IndustrialProposal::class, 'user_id');
    }


    // helper roll check
    public function hasRole($role)
    {
        return $this->role === $role;
    }


        public function supervisor()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function coSupervisors()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function rCell()
    {
        return $this->belongsTo(RCell::class, 'r_cell_id');
    }
}
