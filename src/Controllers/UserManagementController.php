<?php

namespace ArtinCMS\LUM\Controllers;

use ArtinCMS\LUM\Models\RoleManagement;
use ArtinCMS\LUM\Models\UserManagement;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserManagementController extends Controller
{
    public function index ()
    {
        return view('laravel_user_management::backend.index');
    }

    public function getUsers()
    {
        $users = UserManagement::query();

        return Datatables::eloquent($users)
            ->editColumn('id', function ($data) {
                return LUM_GetEncodeId($data->id);
            })
            ->addColumn('main_id', function ($data) {
                return $data->id;
            })
            ->addColumn('created_at', function ($data) {
                return LUM_Date_GtoJ($data->created_at);
            })
            ->make(true);
    }

    public function getRoles(Request $request)
    {
        $roles = RoleManagement::query();

        return Datatables::eloquent($roles)
            ->editColumn('id', function ($data) {
                return LUM_GetEncodeId($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_Date_GtoJ($data->created_at);
            })
            ->make(true);
    }
    public function getEditUserForm(Request $request)
    {

    }
}
