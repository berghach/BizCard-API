<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'bio'
    ];
    public function contact():HasOne{
        return $this->hasOne(Contact::class);
    }
    public function links():HasManyThrough{
        return $this->hasManyThrough(Link::class, Contact::class, 'card', 'contact', 'id', 'id');
    }
}
