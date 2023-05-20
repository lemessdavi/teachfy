<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'folder_id',
        'public',
        'clonable'
    ];
    
    #folder father
    public function folder():BelongsTo{
        return $this->belongsTo(Folder::class);
    }

    #child folders
    public function folders():HasMany{
        return $this->hasMany(Folder::class);
    }
}
