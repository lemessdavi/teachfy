<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'deck_id',
        'deck_type',
        'type',
        'question',
        'answer',
        'points'
    ];
    
    public function deck():BelongsTo{
        return $this->belongsTo(Deck::class);
    }

}
