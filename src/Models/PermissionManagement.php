<?php

namespace ArtinCMS\LUM\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PermissionManagement extends Model
{
    use SoftDeletes;
    protected $table = 'lum_permissions';

}