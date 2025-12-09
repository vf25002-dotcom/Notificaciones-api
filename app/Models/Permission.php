<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permissions';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PERM_CODE',
        'PERM_NAME',
        'PERM_DESCRIPTION',
        'PERM_MENU_AREA',
        'PERM_ROUTE_NAME',
        'PERM_CONTROLLER',
        'PERM_ACTION',
        'PERM_MENU_PARENT_LABEL',
        'PERM_MENU_PARENT_GROUP',
        'PERM_MENU_PARENT_ID',
        'PERM_MENU_ORDER',
        'PERM_STATUS',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions', 'PERM_ID', 'ROLE_ID')
            ->withTimestamps();
    }
}
