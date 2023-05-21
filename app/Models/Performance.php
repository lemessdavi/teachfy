<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'card_id',
        'user_id',
        'performance'
    ];
    
    public function card():BelongsTo{
        return $this->belongsTo(Card::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
