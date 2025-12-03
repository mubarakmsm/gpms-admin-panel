<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'supervisor_id',
        'title',
        'description',
        'meeting_date',
        'duration_minutes',
        'meeting_type',
        'status',
        'notes',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
