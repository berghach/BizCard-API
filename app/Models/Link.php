<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url'
    ];

    public function card():BelongsTo{
        return $this->belongsTo(Card::class);
    }
}
