<?php

namespace ArtinCMS\LUM\Controllers;

use ArtinCMS\LUM\Models\UserManagement;
use ArtinCMS\LUM\Requests\User_Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LUM_UserManagementController extends Controller
{
    public function index()
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

    public function getEditUserForm(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = UserManagement::find(LUM_GetDecodeId($request->item_id));
            $item->encode_id = LUM_GetEncodeId($item->id);
            $item_form = view('laravel_user_management::backend.view.edit_user_form', compact('item'))->render();
            $res['success'] = true;
            $res['get_edit_item'] = $item_form;

            return $res;
        } catch (\Exception $e)
        {
            DB::rollback();
            $res =
                [
                    'success' => false,
                    'message' => [['title' => 'خطا در دریافت اطلاعات:', 'items' => ['در دریافت اطلاات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return json_encode($res);
        };
    }

    public function editUser(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $roles = $this->role_model::find(LUM_GetDecodeId($request->item_id));
            $roles->name = $request->name;
            $roles->display_name = $request->display_name;
            $roles->description = $request->description;
            if (auth()->check())
            {
                $auth = auth()->id();
            }
            else
            {
                $auth = 0;

            }
            $roles->created_by = $auth;
            $roles->save();
            $res =
                [
                    'success' => true,
                    'title'   => "ثبت نقش",
                    'message' => 'نقش با موفقیت ثبت شد.'
                ];
            DB::commit();

            return $res;
        } catch (\Exception $e)
        {
            DB::rollback();
            $res =
                [
                    'success' => false,
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return json_encode($res);
        }
    }

    public function addUsers(User_Request $request)
    {
        dd($request->all());
        DB::beginTransaction();
        try
        {

            $user = new UserManagement();
            $user->username = $request->username ;
            $user->password = bcrypt($request->password);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->father_name = $request->father_name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->email_confirmed = $request->email_confirmed;
            $user->mobile_confirmed = $request->mobile_confirmed;
            $user->user_confirmed = $request->user_confirmed;
            $user->save() ;
            $res =
                [
                    'success' => true,
                    'title'   => "اضافه کردن کاربر",
                    'message' => 'کاربر با موفقیت اضافه شد .'
                ];

            DB::commit();

            return $res;
        } catch (\Exception $e)
        {
            DB::rollback();
            $res =
                [
                    'success' => false,
                    'message' => [['title' => 'خطا درثبت اطلاعات:', 'items' => ['در ثبت اطلاات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return json_encode($res);
        }
    }

}
