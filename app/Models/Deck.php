<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id', #deck creator
        'folder_id',
        'name',
        'public',
        'clonable',
        'feedback',
        'type'
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
}
