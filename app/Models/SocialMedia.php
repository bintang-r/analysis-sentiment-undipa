<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media_232187';

    protected $primaryKey = 'id_232187'; // <-- wajib

    public $incrementing = true;

    protected $keyType = 'int';


    protected $fillable = [
        'name_232187',
        'is_active_232187',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'social_media_id_232187', 'id_232187');
    }
}
