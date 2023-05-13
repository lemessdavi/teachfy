<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'card_id',
        'description',
        'correct_answer'
    ];
    
    public function card():BelongsTo{
        return $this->belongsTo(Card::class);
    }
}
