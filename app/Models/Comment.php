<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments_232187';

    protected $fillable = [
        'user_id_232187',
        'social_media_id_232187',
        'comment_232187',
        'status_232187',
    ];

    public function social_media()
    {
        return $this->belongsTo(SocialMedia::class, 'social_media_id_232187', 'id_232187')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_232187', 'id_232187')->withDefault();
    }

    public function getAttributeCreatedAt($value)
    {
        return $value
            ? Carbon::parse($value)->format('Y/m/d H:i:s')
            : null;
    }
}
