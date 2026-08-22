<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job_listings';
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'category_id',
        'user_id',
        'experience_level',
        'education_level',
        'skills',
        'benefits',
        'remote_option',
        'job_type',
        'application_deadline',
        'company_name',
        'company_website',
        'status',
    ];
    protected $casts = [
        'application_deadline' => 'date',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
