<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory; // ← Add this line

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'amount',
        'status',
        'receipt_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
