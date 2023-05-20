<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function answers():HasMany{
        return $this->hasMany(Answer::class);
    }

    public function options():HasMany{
        return $this->hasMany(Option::class);
    }

    public function performances():HasMany{
        return $this->hasMany(Performance::class);
    }
}
