<?php

namespace ArtinCMS\LUM\Controllers;

//namespace App\Http\Controllers\Vendor\LUM;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArtinCMS\LUM\Requests\User_Request;
use Yajra\DataTables\Facades\DataTables;
use ArtinCMS\LUM\Requests\User_Edit_Request;

class RegisterController extends Controller
{
    protected $register_model = '';

    public function __construct(array $settings = [])
    {
        $this->user_model = config('laravel_user_management.register_model');
    }

    public function index()
    {
        $term_url = config('laravel_user_management.accept_term_url');
        return view('laravel_user_management::frontend.auth.register',compact('term_url'));
    }
}
