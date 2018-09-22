<?php

namespace ArtinCMS\LUM\Controllers;

use ArtinCMS\LUM\Models\PermissionCategoryManagement;
use ArtinCMS\LUM\Models\PermissionManagement;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PermissionManagementController extends Controller
{
    private function deleteAllPermissinCategory($id)
    {
        $item = PermissionCategoryManagement::with('childrens')->find($id);
        $item->delete();
        if ($item->childrens)
        {
            if ($item->childrens)
            {
                foreach ($item->childrens as $child)
                {
                    $id = $child->id;
                    $this->deleteAllPermissinCategory($id);
                }
            }
        }
    }
    //--------------------------permission cateogory function -------------------------------------------//
    public function getPermissionCategorys(Request $request)
    {
        $permissions = PermissionCategoryManagement::with('parent');

        return Datatables::eloquent($permissions)
            ->editColumn('id', function ($data) {
                return LUM_GetEncodeId($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_Date_GtoJ($data->created_at);
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
            $item = PermissionCategoryManagement::find(LUM_GetDecodeId($request->item_id));
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

            $item = PermissionCategoryManagement::with('parent')->find(LUM_GetDecodeId($request->item_id));
            $item->encode_id = LUM_GetEncodeId($item->id);
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
            $permissions = PermissionCategoryManagement::find(LUM_GetDecodeId($request->item_id));
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
        DB::beginTransaction();
        try
        {
            $item = PermissionCategoryManagement::with('childrens')->find(LUM_GetDecodeId($request->item_id));
            $item->delete();
            if ($item->childrens)
            {
                foreach ($item->childrens as $child)
                {
                    $id = $child->id;
                    $this->deleteAllPermissinCategory($id);
                }
            }
            DB::commit();
            $res =
                [
                    'success' => true,
                    'title'   => "حذف دسته بندی",
                    'message' => 'دسته بندی با موفقیت حذف شد.'
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
        $permissions = PermissionManagement::where('category_id',LUM_GetDecodeId($request->item_id));

        return Datatables::eloquent($permissions)
            ->editColumn('id', function ($data) {
                return LUM_GetEncodeId($data->id);
            })
            ->addColumn('created_at', function ($data) {
                return LUM_Date_GtoJ($data->created_at);
            })
            ->make(true);
    }

    public function addPermissions(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $permissions = new PermissionManagement;
            $permissions->name = $request->name;
            $permissions->category_id =LUM_GetDecodeId($request->category_id);
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

    public function changePermissionStauts(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = PermissionManagement::find(LUM_GetDecodeId($request->item_id));
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
            $item = PermissionManagement::find(LUM_GetDecodeId($request->item_id));
            $item->encode_id = LUM_GetEncodeId($item->id);
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
        DB::beginTransaction();
        try
        {
            $permissions = PermissionManagement::find(LUM_GetDecodeId($request->item_id));
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

    public function trashPermissions(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $gallery = PermissionManagement::find(LUM_GetDecodeId($request->item_id));
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


}
