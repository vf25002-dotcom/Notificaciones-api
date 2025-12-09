<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'ROLE_ID';

    protected $fillable = [
        'ROLE_CODE',
        'ROLE_NAME',
        'ROLE_DESCRIPTION',
        'ROLE_STATUS',
    ];

    public function users()
    {
        return $this->belongsToMany(Usuario::class, 'user_role', 'ROLE_ID', 'USER_ID')
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'ROLE_ID', 'PERM_ID')
            ->withTimestamps();
    }
}
