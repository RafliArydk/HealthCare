<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'image_path',
    'type',
    'cnn_label',
    'confidence_score',
    'model_version',
    'status',
    'error_code',
    'initial_analysis',
    'consent_training',
])]
class Scan extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'confidence_score' => 'decimal:4',
            'consent_training' => 'boolean',
        ];
    }

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

    // Relasi: 1 Scan punya banyak Audit Log
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
