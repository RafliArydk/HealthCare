<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'image_path', 'type', 'initial_analysis'];

    // Relasi: 1 Scan milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 Scan punya banyak Chat
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}