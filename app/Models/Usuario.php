<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'USUARIO',
        'PASSWORD',
        'SUCURSAL',
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    public function getAuthIdentifierName()
    {
        return 'USUARIO';
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'USER_ID', 'ROLE_ID')
            ->withTimestamps();
    }

    public function hasPermission($permissionCode)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('PERM_CODE', $permissionCode)) {
                return true;
            }
        }
        return false;
    }
}
