<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'deck_id',
        'permission'
    ];
    
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function deck():BelongsTo{
        return $this->belongsTo(Deck::class);
    }
}