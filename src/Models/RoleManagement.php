<?php

namespace ArtinCMS\LUM\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RoleManagement extends Model
{
    use SoftDeletes;
    protected $table = 'lum_roles';

}