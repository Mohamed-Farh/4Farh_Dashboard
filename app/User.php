<?php

namespace App;

use App\Models\ProductReview;
use App\Models\UserAddress;
use Cviebrock\EloquentSluggable\Sluggable;
use Mindscms\Entrust\Traits\EntrustUserWithPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use  Notifiable, EntrustUserWithPermissionsTrait , SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'mobile', 'password', 'user_image', 'status'
    ];


    protected $appends = ['full_name'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $searchable = [
        'columns' => [
            'users.first_name' => 10,
            'users.last_name' => 10,
            'users.username' => 10,
            'users.email' => 10,
            'users.mobile' => 10,
        ],
    ];

    public function getFullNameAttribute(): string
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}
