<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "users_232187";

    protected $fillable = [
        'force_logout_232187',
        'username_232187',
        'name_232187',
        'status_232187',
        'avatar_232187',
        'role_232187',
        'email_232187',
        'password_232187',
        'email_verified_at_232187',
        'last_login_time_232187',
        'last_login_ip_232187',
        'last_seen_time_232187',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_232187',
        'remember_token_232187',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at_232187' => 'datetime',
        'password_232187' => 'hashed',
    ];

    // GET AVATAR URL
    public function avatarUrl()
    {
        return $this->avatar
            ? url('storage/' . $this->avatar)
            : 'https://gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=1024';
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id_232187', 'id_232187');
    }
}
