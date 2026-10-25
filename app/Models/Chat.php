<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['scan_id', 'sender', 'message'];

    // Relasi: 1 Chat milik 1 Scan
    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }
}