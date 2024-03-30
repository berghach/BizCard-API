<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'company',
        'card_owner',
        'occupation',
        'adresse',
        'bio',
        'phone_number',
        'e_mail',
        'user_id'
    ];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function links():HasMany{
        return $this->hasMany(Link::class);
    }
}
