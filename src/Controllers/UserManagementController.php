<?php

namespace ArtinCMS\LUM\Controllers;

use ArtinCMS\LUM\Models\LogManagement;
use ArtinCMS\LUM\Models\PermissionCategoryManagement;
use ArtinCMS\LUM\Models\PermissionManagement;
use ArtinCMS\LUM\Models\RoleManagement;
use ArtinCMS\LUM\Models\UserManagement;
use ArtinCMS\LUM\Requests\User_Request;
use ArtinCMS\LUM\Traits\User;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserManagementController extends Controller
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
            $roles = RoleManagement::find(LUM_GetDecodeId($request->item_id));
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

    public function addRoles(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $roles = new RoleManagement;
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

    public function changeRoleStauts(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = RoleManagement::find(LUM_GetDecodeId($request->item_id));
            if ($request->is_active == "true")
            {
                $item->is_active = "1";
                $res['message'] = ' آیتم فعال گردید';
            }
            else
            {
                $item->is_active = "0";
                $res['message'] = 'آیتم غیر فعال شد';
            }
            $item->save();
            $res['success'] = true;
            $res['title'] = 'وضعیت آیتم تغییر پیدا کرد .';
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
        };
    }

    public function getEditRolesForm(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = RoleManagement::find(LUM_GetDecodeId($request->item_id));
            $item->encode_id = LUM_GetEncodeId($item->id);
            $item_form = view('laravel_user_management::backend.view.edit_role_form', compact('item'))->render();
            DB::commit();
            $res['success'] = true;
            $res['get_edit_item'] = $item_form;

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
        };
    }

    public function editRoles(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $roles = RoleManagement::find(LUM_GetDecodeId($request->item_id));
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

    public function trashRoles(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $gallery = RoleManagement::find(LUM_GetDecodeId($request->item_id));
            $gallery->delete();
            DB::commit();
            $res =
                [
                    'success' => true,
                    'title'   => "حذف نقش",
                    'message' => 'نقش با موفقیت حذف شد.'
                ];
            return $res;
        } catch (\Exception $e)
        {
            DB::rollback();
            $res =
                [
                    'success' => false,
                    'message' => [['title' => 'خطا درحذف اطلاعات:', 'items' => ['در حذف اطلاات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
                ];

            return json_encode($res);
        }

    }

    public function getUserRoleForm (Request $request)
    {
        $item_id = $request->item_id ;
        $user = UserManagement::find(LUM_GetDecodeId($item_id));
        if(isset( $user->roles))
        {
            $user_roles = $user->roles ;
            $permission_ids = [] ;
            foreach ($user_roles as $user_perm)
            {
                $permission_ids[] = $user_perm->id ;
            }
        }
        else
        {
            $permission_ids = [] ;
        }
        $roles = RoleManagement::all() ;
        if(count($roles) == count($permission_ids) )
        {
            $class = 'fa-check-circle';
            $status = 2 ;
        }
        elseif(count($permission_ids) > 0)
        {
            $class = 'fa-dot-circle';
            $status = 1 ;
        }
        else
        {
            $class = 'fa-circle';
            $status = 0 ;

        }
        $item_form = view('laravel_user_management::backend.view.user_role', compact('roles','item_id','permission_ids','user','class','status'))->render();
        $res['success'] = true;
        $res['get_user_role'] = $item_form;

        return $res;
    }

    public function addRoleToUsers(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item_id = $request->item_id ;
            $type = $request->type ;
            $item_id = LUM_GetDecodeId($request->item_id) ;

            $user = UserManagement::find($item_id);
            $user->roles()->sync($request->items);
            $res =
                [
                    'success' => true,
                    'title'   => "ثبت دسترسی",
                    'message' => 'دسترسی با موفقیت ثبت شد.'
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

    public function getLogs(Request $request)
    {
        $users = LogManagement::query();

        return Datatables::eloquent($users)
            ->editColumn('id', function ($data) {
                return LUM_GetEncodeId($data->id);
            })
            ->addColumn('username', function ($data) {
                $user = UserManagement::find($data->user_id) ;
                if($user)
                {
                    if (isset($user->name))
                    {
                        return $user->name;
                    }
                    else
                    {
                        return '' ;
                    }
                }
                else
                {
                    return '' ;
                }
            })
            ->editColumn('created_at', function ($data) {
                return LUM_Date_GtoJ($data->created_at);
            })
            ->make(true);
    }

    public function addUsers(User_Request $request)
    {
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
