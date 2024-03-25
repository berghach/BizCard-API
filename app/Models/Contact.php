<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone_number',
        'e_mail'
    ];

    public function links():HasMany{
        return $this->hasMany(Link::class);
    }
    public function card():BelongsTo{
        return $this->belongsTo(Card::class);
    }
}
