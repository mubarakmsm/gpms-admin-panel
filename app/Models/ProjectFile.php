<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'mime_type',
        'description',
        'version',
        'is_final',
    ];

    protected $casts = [
        'is_final' => 'boolean',
        'version' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function uploader()
    {
        return $this->belongsTo(TeamMember::class, 'uploaded_by');
    }
}

