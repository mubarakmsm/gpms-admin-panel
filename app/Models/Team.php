<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'supervisor_id',
        'name',
        'project_title',
        'project_title_eng',
        'project_description',
        'project_description_eng',
        'status',
        'progress',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }
}
