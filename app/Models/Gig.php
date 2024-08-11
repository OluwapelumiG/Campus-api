<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'location', 'category', 'posted_by', 'student', 'price'
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'gig_id');
    }
}
