<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_eng', 
        'description',
        'description_eng',
        'dean_name',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // العلاقة مع الأقسام
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    // الحصول على الأقسام النشطة فقط
    public function activeDepartments()
    {
        return $this->hasMany(Department::class)->where('status', 'active');
    }

    // scope للعناصر النشطة
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // accessor للاسم الكامل
    public function getFullNameAttribute()
    {
        return $this->name . ($this->name_eng ? " ({$this->name_eng})" : '');
    }
}