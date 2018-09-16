<?php

namespace ArtinCMS\LUM\Models;

use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{
    protected $table = 'faq_manager';
    public function user()
    {
        return $this->belongsTo(config('laravel_user_management.user_model'), 'created_by');
    }
}
