<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'social_media_id',
        'comment',
        'status',
    ];

    public function social_media()
    {
        return $this->belongsTo(SocialMedia::class, 'social_media_id', 'id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function getAttributeCreatedAt($value)
    {
        return $value
            ? Carbon::parse($value)->format('Y/m/d H:i:s')
            : null;
    }
}
