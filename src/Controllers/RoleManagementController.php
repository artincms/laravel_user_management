<?php

namespace ArtinCMS\LUM\Controllers;

use ArtinCMS\LUM\Models\LogManagement;
use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoleManagementController extends Controller
{

    protected $role_model;
    protected $user_model;
    protected $permission_model;
    protected $team_model;

    public function __construct(array $settings = [])
    {
        $this->role_model = config('laratrust.models.role');
        $this->team_model = config('laratrust.models.team');
        $this->permission_model = config('laratrust.models.permission');
        $this->user_model = config('laravel_user_management.user_model');
    }

    public function getRoles(Request $request)
    {
        $roles = $this->role_model::query();

        return Datatables::eloquent($roles)
            ->editColumn('id', function ($data) {
                return LUM_get_encode_id($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_date_g_to_j($data->created_at);
            })
            ->make(true);
    }

    public function getTeams(Request $request)
    {
        $roles = $this->team_model::query();

        return Datatables::eloquent($roles)
            ->editColumn('id', function ($data) {
                return LUM_get_encode_id($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_date_g_to_j($data->created_at);
            })
            ->make(true);
    }

    public function addRoles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:'.config('laratrust.tables.roles').',name,Null,id,deleted_at,NULL',
        ],[
            'name.unique'=>'نام تکراری است .',
            'name.required'=>'نام الزامی است .',
        ]);
        if ($validator->fails())
        {
            $api_errors = LUM_validation_error_to_api_json($validator->errors());
            $res =
                [
                    'success' => false,
                    'errors'  => $api_errors,
                    'message' => [['title' => 'لطفا موارد زیر را بررسی نمایید:', 'items' => $api_errors]]
                ];
            return json_encode($res) ;

        }
        else
        {
            DB::beginTransaction();
            try
            {
                $roles = new  $this->role_model;
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
    }

    public function addTeams(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $roles = new  $this->team_model;
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
                    'title'   => "ثبت تیم",
                    'message' => 'تیم با موفقیت ثبت شد.'
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
            $item = $this->role_model::find(LUM_get_decode_id($request->item_id));
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

    public function changeTeamStauts(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->team_model::find(LUM_get_decode_id($request->item_id));
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
            $item = $this->role_model::find(LUM_get_decode_id($request->item_id));
            $item->encode_id = LUM_get_encode_id($item->id);
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
        }
    }

    public function getEditTeamsForm(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->team_model::find(LUM_get_decode_id($request->item_id));
            $item->encode_id = LUM_get_encode_id($item->id);
            $item_form = view('laravel_user_management::backend.view.edit_team_form', compact('item'))->render();
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
        }
    }

    public function editRoles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:'.config('laratrust.tables.roles').',name,'.LUM_get_decode_id($request->item_id).',id,deleted_at,NULL',
        ],[
            'name.unique'=>'نام تکراری است .',
            'name.required'=>'نام الزامی است .',
        ]);
        if ($validator->fails())
        {
            $api_errors = LUM_validation_error_to_api_json($validator->errors());
            $res =
                [
                    'success' => false,
                    'errors'  => $api_errors,
                    'message' => [['title' => 'لطفا موارد زیر را بررسی نمایید:', 'items' => $api_errors]]
                ];
            return json_encode($res) ;

        }
        else
        {
            DB::beginTransaction();
            try
            {
                $roles = $this->role_model::find(LUM_get_decode_id($request->item_id));
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
    }

    public function editTeams(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $roles = $this->team_model::find(LUM_get_decode_id($request->item_id));
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
            $role = $this->role_model::find(LUM_get_decode_id($request->item_id));
            $role->delete();
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

    public function trashTeams(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $role = $this->team_model::find(LUM_get_decode_id($request->item_id));
            $role->delete();
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

    public function getUserRoleForm(Request $request)
    {
        $item_id = $request->item_id;
        $user = $this->user_model::find(LUM_get_decode_id($item_id));
        if (isset($user->roles))
        {
            $user_roles = $user->roles;
            $permission_ids = [];
            foreach ($user_roles as $user_perm)
            {
                $permission_ids[] = $user_perm->id;
            }
        }
        else
        {
            $permission_ids = [];
        }
        $roles = $this->role_model::all();
        if (count($roles) == count($permission_ids))
        {
            $class = 'fa-check-circle';
            $status = 2;
        }
        elseif (count($permission_ids) > 0)
        {
            $class = 'fa-dot-circle';
            $status = 1;
        }
        else
        {
            $class = 'fa-circle';
            $status = 0;

        }
        $item_form = view('laravel_user_management::backend.view.user_role', compact('roles', 'item_id', 'permission_ids', 'user', 'class', 'status'))->render();
        $res['success'] = true;
        $res['get_user_role'] = $item_form;

        return $res;
    }

    public function getUserTeamForm(Request $request)
    {
        $item_id = $request->item_id;
        $user = $this->user_model::find(LUM_get_decode_id($item_id));
        dd($user->roles->toArray());
        if (isset($user->teams))
        {
            $user_roles = $user->teams;
            $permission_ids = [];
            foreach ($user_roles as $user_perm)
            {
                $permission_ids[] = $user_perm->id;
            }
        }
        else
        {
            $permission_ids = [];
        }
        $roles = $this->role_model::all();
        if (count($roles) == count($permission_ids))
        {
            $class = 'fa-check-circle';
            $status = 2;
        }
        elseif (count($permission_ids) > 0)
        {
            $class = 'fa-dot-circle';
            $status = 1;
        }
        else
        {
            $class = 'fa-circle';
            $status = 0;

        }
        $item_form = view('laravel_user_management::backend.view.user_role', compact('roles', 'item_id', 'permission_ids', 'user', 'class', 'status'))->render();
        $res['success'] = true;
        $res['get_user_role'] = $item_form;

        return $res;
    }

    public function addRoleToUsers(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item_id = $request->item_id;
            $type = $request->type;
            $item_id = LUM_get_decode_id($request->item_id);

            $user = $this->user_model::find($item_id);
            $user->roles()->sync($request->items);
            \Artisan::call('cache:clear');

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
                return LUM_get_encode_id($data->id);
            })
            ->addColumn('username', function ($data) {
                $user = $this->user_model::find($data->user_id);
                if ($user)
                {
                    if (isset($user->name))
                    {
                        return $user->name;
                    }
                    else
                    {
                        return '';
                    }
                }
                else
                {
                    return '';
                }
            })
            ->editColumn('created_at', function ($data) {
                return LUM_date_g_to_j($data->created_at);
            })
            ->make(true);
    }
}