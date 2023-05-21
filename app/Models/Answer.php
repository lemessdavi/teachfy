<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'card_id',
        'option_id',
        'difficulty',
        'grade',
        'feedback'
    ];
    
    public function card():BelongsTo{
        return $this->belongsTo(Card::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function option():BelongsTo{
        return $this->belongsTo(Option::class);
    }

}
