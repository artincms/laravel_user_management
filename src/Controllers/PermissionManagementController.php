<?php

namespace ArtinCMS\LUM\Controllers;

use DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArtinCMS\LUM\Models\UserManagement;
use Yajra\DataTables\Facades\DataTables;
use ArtinCMS\LUM\Models\PermissionCategoryManagement;

class PermissionManagementController extends Controller
{
    protected $role_model = '';
    protected $permission_model = '';

    public function __construct(array $settings = [])
    {
        $this->role_model =config('laratrust.models.role');
        $this->permission_model =config('laratrust.models.permission');
    }

    private function deleteAllPermissinCategory($id)
    {
        $item = PermissionCategoryManagement::with('childItems','Children')->find($id);
        $item->delete();
//        if ($item->childItems)
//        {
//            if ($item->childItems)
//            {
//                foreach ($item->childItems as $child)
//                {
//                    $id = $child->id;
//                    $this->deleteAllPermissinCategory($id);
//                }
//            }
//        }
    }
    //--------------------------permission cateogory function -------------------------------------------//
    public function getPermissionCategorys(Request $request)
    {
        $permissions = PermissionCategoryManagement::with('parent');

        return Datatables::eloquent($permissions)
            ->editColumn('id', function ($data) {
                return LUM_get_encode_id($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_date_g_to_j($data->created_at);
            })
            ->make(true);
    }

    public function addPermissionCategorys(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $permissions = new PermissionCategoryManagement;
            $permissions->title = $request->title;
            $permissions->parent_id = $request->parent_id;
            $permissions->description = $request->description;
            if (auth()->check())
            {
                $auth = auth()->id();
            }
            else
            {
                $auth = 0;

            }
            $permissions->created_by = $auth;
            $permissions->save();
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

    public function changePermissionCategoryStauts(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = PermissionCategoryManagement::find(LUM_get_decode_id($request->item_id));
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

    public function getEditPermissionCategorysForm(Request $request)
    {

            $item = PermissionCategoryManagement::with('parent')->find(LUM_get_decode_id($request->item_id));
            $item->encode_id = LUM_get_encode_id($item->id);
            $item_form = view('laravel_user_management::backend.view.edit_permission_category_form', compact('item'))->render();
            $res['success'] = true;
            $res['get_edit_item'] = $item_form;

            return $res;
    }

    public function editPermissionCategorys(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $permissions = PermissionCategoryManagement::find(LUM_get_decode_id($request->item_id));
            $permissions->title = $request->title;
            $permissions->parent_id = $request->parent_id;
            $permissions->description = $request->description;
            if (auth()->check())
            {
                $auth = auth()->id();
            }
            else
            {
                $auth = 0;

            }
            $permissions->created_by = $auth;
            $permissions->save();
            $res =
                [
                    'success' => true,
                    'title'   => "ویرایش دسته بندی",
                    'message' => 'دسته بندی با موفقیت ویرایش شد.'
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

    public function trashPermissionCategorys(Request $request)
    {
//        DB::beginTransaction();
//        try
//        {
            $item = PermissionCategoryManagement::with('childItems','Children')->find(LUM_get_decode_id($request->item_id));
            $item->delete();
            if ($item->childItems)
            {
                foreach ($item->children as $child)
                {
                    $id = $child->id;
                    $this->deleteAllPermissinCategory($id);
                }
            }
//            DB::commit();
            $res =
                [
                    'success' => true,
                    'title'   => "حذف دسته بندی",
                    'message' => 'دسته بندی با موفقیت حذف شد.'
                ];
            return $res;
//        } catch (\Exception $e)
//        {
//            DB::rollback();
//            $res =
//                [
//                    'success' => false,
//                    'message' => [['title' => 'خطا درحذف اطلاعات:', 'items' => ['در حذف اطلاات خطا روی داده است لطفا دوباره سعی کنید', 'درصورت تکرار این خطا لطفا با مدیریت تماس حاصل فرمایید.']]]
//                ];
//
//            return json_encode($res);
//        }

    }

    public function autoCompletePermissionCategory(Request $request)
    {
        $x = $request->term;
        $data = PermissionCategoryManagement::select("id", 'title AS text')->where('is_active', '1');
        if ($x['term'] != '...')
        {
            $data = PermissionCategoryManagement::select("id", 'title AS text')
                ->where('is_active', '1')
                ->where("title", "LIKE", "%" . $x['term'] . "%");
        }
        $data = $data->get();
        $data = ['results' => $data];
        return response()->json($data);
    }

    //--------------------------permission function -----------------------------------------------------------//
    public function getPermissions(Request $request)
    {
        $permissions = $this->permission_model::where('category_id',LUM_get_decode_id($request->item_id));

        return Datatables::eloquent($permissions)
            ->editColumn('id', function ($data) {
                return LUM_get_encode_id($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_date_g_to_j($data->created_at);
            })
            ->make(true);
    }

    public function addPermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:'.config('laratrust.tables.permissions').',name,NULL,id,deleted_at,NULL',
        ],[
            'name.unique'=>'نام تکراری است .'
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
                $permissions = new $this->permission_model;
                $permissions->name = $request->name;
                $permissions->category_id =LUM_get_decode_id($request->category_id);
                $permissions->display_name = $request->display_name;
                $permissions->description = $request->description;
                if (auth()->check())
                {
                    $auth = auth()->id();
                }
                else
                {
                    $auth = 0;

                }
                $permissions->created_by = $auth;
                $permissions->save();
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
    }

    public function changePermissionStauts(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->permission_model::find(LUM_get_decode_id($request->item_id));
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

    public function getEditPermissionsForm(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->permission_model::find(LUM_get_decode_id($request->item_id));
            $item->encode_id = LUM_get_encode_id($item->id);
            $item->category_encode_id = LUM_get_encode_id($item->category_id);
            $item_form = view('laravel_user_management::backend.view.edit_permission_form', compact('item'))->render();
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

    public function editPermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:'.config('laratrust.tables.permissions').',name,'.LUM_get_decode_id($request->item_id).',id,deleted_at,NULL',
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
                $permissions = $this->permission_model::find(LUM_get_decode_id($request->item_id));
                $permissions->name = $request->name;
                $permissions->display_name = $request->display_name;
                $permissions->description = $request->description;
                if (auth()->check())
                {
                    $auth = auth()->id();
                }
                else
                {
                    $auth = 0;

                }
                $permissions->created_by = $auth;
                $permissions->save();
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

    }

    public function trashPermissions(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $gallery = $this->permission_model::find(LUM_get_decode_id($request->item_id));
            $gallery->delete();
            DB::commit();
            $res =
                [
                    'success' => true,
                    'title'   => "حذف دسترسی",
                    'message' => 'دسترسی با موفقیت حذف شد.'
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

    public function addRoleToPermission(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item_id = $request->item_id ;
            $type = $request->type ;
            $item_id = LUM_get_decode_id($request->item_id) ;
            $type = $request->type ;
            if($type == 2)
            {
                $role = $this->role_model::find($item_id);
                $role->permissions()->sync($request->items);
                $res =
                    [
                        'success' => true,
                        'title'   => "ثبت دسترسی",
                        'message' => 'دسترسی با موفقیت ثبت شد.'
                    ];
            }
            else if($type = 1)
            {
                $user = UserManagement::find($item_id);
                $user->permissions()->sync($request->items);
                $res =
                    [
                        'success' => true,
                        'title'   => "ثبت دسترسی",
                        'message' => 'دسترسی با موفقیت ثبت شد.'
                    ];
            }

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

    public function getRolePermissionForm(Request $request)
    {
        $type = $request->type ;
        $item_id = $request->item_id ;
        if($type == 1)
        {
            $user = UserManagement::find(LUM_get_decode_id($item_id));
            if(isset( $user->permissions))
            {
                $user_permissions = $user->permissions ;
                $permission_ids = [] ;
                foreach ($user_permissions as $user_perm)
                {
                    $permission_ids[] = $user_perm->id ;
                }
            }
            else
            {
                $permission_ids = [] ;
            }
        }
        else
        {
            $role = $this->role_model::find(LUM_get_decode_id($item_id));
            if(isset( $role->permissions))
            {
                $role_permissions = $role->permissions ;
                $permission_ids = [] ;
                foreach ($role_permissions as $role_perm)
                {
                    $permission_ids[] = $role_perm->id ;
                }
            }
            else
            {
                $permission_ids = [] ;
            }
        }
        $permissions = LUM_generate_permissions_layout('ArtinCMS\LUM\Models\PermissionCategoryManagement',0,$permission_ids);
        $item_form = view('laravel_user_management::backend.view.permission_role', compact('permissions','type','item_id'))->render();
        $res['success'] = true;
        $res['get_permission_role'] = $item_form;

        return $res;
    }


}
