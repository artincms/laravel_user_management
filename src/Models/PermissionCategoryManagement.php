<?php

namespace ArtinCMS\LUM\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PermissionCategoryManagement extends Model
{
    use SoftDeletes;
    protected $table = 'lum_permission_categories';

    public function parent()
    {
        return $this->hasOne('ArtinCMS\LUM\Models\PermissionCategoryManagement', 'id', 'parent_id');
    }

    public function Children()
    {
        return $this->hasMany('ArtinCMS\LUM\Models\PermissionCategoryManagement', 'parent_id', 'id');
    }

    public function childItems()
    {
        return $this->hasMany(config('laratrust.models.permission'), 'category_id', 'id');
    }
}