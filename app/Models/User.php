<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Optima\DepotStock\Support\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use HasRoles;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'client_id',   // 👈 IMPORTANT: allow client_id to be saved
    ];

    /**
     * Attributes that should be hidden for arrays / JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * Many-to-many: user ↔ roles (pivot table: role_user).
     */
    public function roles()
    {
        return $this->belongsToMany(\Optima\DepotStock\Models\Role::class, 'role_user');
    }

    /**
     * Optional link to a client (for client portal users).
     */
    public function client()
    {
        return $this->belongsTo(\Optima\DepotStock\Models\Client::class);
    }

    /**
     * Quick helper: $user->hasRole('admin'), etc.
     */
    public function hasRole(string $name): bool
    {
        return $this->roles->contains('name', $name);
    }
}