<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supervisor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'specialization',
        'specialization_eng',
        'academic_rank',
        'academic_rank_eng',
        'max_projects',
        'current_projects',
        'expertise_areas',
        'expertise_areas_eng',
        'bio',
        'status',
    ];

    protected $casts = [
        'expertise_areas' => 'array',
        'expertise_areas_eng' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'supervisor_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}