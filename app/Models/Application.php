<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id', 'student_id', 'notes', 'status',
    ];

    public function gig()
    {
        return $this->belongsTo(Gig::class, 'gig_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
