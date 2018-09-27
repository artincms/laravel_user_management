<?php

namespace ArtinCMS\LUM\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserManagement extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'lum_users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function permissions()
    {
        return $this->morphToMany('ArtinCMS\LUM\Models\PermissionManagement' , 'user','lum_permission_user','user_id','permission_id');
    }

    public function roles()
    {
        return $this->morphToMany('ArtinCMS\LUM\Models\RoleManagement' , 'user','lum_role_user','user_id','role_id');
    }
}
