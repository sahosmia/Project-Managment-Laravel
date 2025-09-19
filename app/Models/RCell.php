<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RCell extends Model
{
    protected $fillable = [
        'name', 'description', 'research_cell_head'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'r_cell_id');
    }

    public function researchCellHead()
    {
        return $this->belongsTo(User::class, 'research_cell_head');
    }
}
