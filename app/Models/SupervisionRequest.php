<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupervisionRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'supervisor_id',
        'project_summary',
        'message',
        'status',
        'response_message',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
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
