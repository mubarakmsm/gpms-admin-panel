<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'supervisor_id',
        'evaluation_type',
        'technical_score',
        'documentation_score',
        'presentation_score',
        'innovation_score',
        'teamwork_score',
        'total_score',
        'strengths',
        'weaknesses',
        'recommendations',
        'is_final',
    ];

    protected $casts = [
        'technical_score' => 'float',
        'documentation_score' => 'float',
        'presentation_score' => 'float',
        'innovation_score' => 'float',
        'teamwork_score' => 'float',
        'total_score' => 'float',
        'is_final' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
