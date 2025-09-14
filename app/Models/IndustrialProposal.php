<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustrialProposal extends Model
{
    protected $fillable = [
        'user_id',
        'skills',
        'company',
        'supervisor_id',
        'industrial_supervisor_name',
        'industrial_supervisor_phone',
        'industrial_supervisor_email',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
