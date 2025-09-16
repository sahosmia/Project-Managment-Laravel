<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RCell extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

     public function projects()
    {
        return $this->hasMany(Project::class, 'r_cell_id');
    }
}
