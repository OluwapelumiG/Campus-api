<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'user_id', 'message', 'read', 'replying'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replyTo()
    {
        return $this->belongsTo(Message::class, 'replying');
    }
}
