<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function answer():HasOne{
        return $this->hasOne(Answer::class);
    }
}
