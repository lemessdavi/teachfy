<?php

namespace App\Models;

use App\Structural\Enums\DeckType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Deck extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => DeckType::class,
    ];

    protected $fillable = [
        'id',
        'user_id', #deck creator
        'folder_id',
        'name',
        'public',
        'clonable',
        'feedback',
        'type',
        'description'
        //maybe the index?
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function folder():BelongsTo{
        return $this->belongsTo(Folder::class);
    }

    public function participants():HasMany{
        return $this->hasMany(Participant::class);
    }

    public function cards():HasMany{
        return $this->hasMany(Card::class);
    }

    public function options():HasManyThrough{
        return $this->hasManyThrough(Option::class, Card::class);
    }
}
