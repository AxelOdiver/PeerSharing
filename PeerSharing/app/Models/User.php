<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
   use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // ✅ auto-hash on set (Laravel 10/11)
        ];
    }

    public function favorites()
    {
    // Make sure 'Item::class' matches whatever model you are favoring (e.g., Swap::class, Post::class)
    return $this->belongsToMany(User::class, 'favorites', 'user_id', 'item_id')->withTimestamps();
    }
}
