<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'folder_id',
        'public',
        'clonable'
    ];
    
    public function folder():BelongsTo{
        return $this->belongsTo(Folder::class);
    }

}
