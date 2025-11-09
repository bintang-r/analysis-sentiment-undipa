<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media_232187';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'social_media_id', 'id');
    }
}
