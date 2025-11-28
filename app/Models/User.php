<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'provider_id',
        'provider',
        'provider_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
        $user = User::with(['roles', 'permissions', 'userInfor'])->find($id);
    }

    function user_address() {
        return $this->hasMany(UserAddress::class);
    }
    public function userInfor(): HasOne
    {
        return $this->hasOne(UserInfor::class);
    }

    // Other existing methods...

    public function profile()
    {
        return $this->hasOne(UserInfor::class);
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    // }
}
