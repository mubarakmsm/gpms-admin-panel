<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'student_number',
        'academic_year',
        'status',
        'notes',
    ];

    protected $casts = [
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

    public function teamMemberships()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members', 'student_id', 'team_id')
            ->withPivot(['role','joined_at','status'])
            ->withTimestamps();
    }
}
    
