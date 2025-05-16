<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,SoftDeletes,HasApiTokens;
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'password',
        'avatar',
        'about',
        'position',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'email_verified_at',
        'role',
        'remember_token',
        'status',
        'reset_password_token',
        'reset_password_token_exp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'email_verified_at',
        'deleted_at',
        'created_at',
        'updated_at',
        'role',
        'status',
        'remember_token',
        'reset_password_token',
        'reset_password_token_exp'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'accept_push_notifications' => 'boolean',
            'email_newsletter' => 'boolean'
        ];
    }

    public function getAvatarAttribute($value): string | null
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        // Check if the request is an API request
        if (request()->is('api/*') && !empty($value)) {
            // Return the full URL for API requests
            return url($value);
        }

        // Return only the path for web requests
        return $value;
    }

}
