<?php

namespace ArtinCMS\LUM\Controllers;

//namespace App\Http\Controllers\Vendor\LUM;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use ArtinCMS\LUM\Requests\User_Request;
use ArtinCMS\LUM\Requests\User_Edit_Request;

class UserManagementController extends Controller
{
    protected $user_model = '';

    public function __construct(array $settings = [])
    {
        $this->user_model = config('laravel_user_management.user_model');
    }

    public function index()
    {
        return view('laravel_user_management::backend.index');
    }

    public function getUsers()
    {
        $users = $this->user_model::query();

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
            $item = $this->user_model::find(LUM_GetDecodeId($request->item_id));
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

    public function editUser(User_Edit_Request $request)
    {
        DB::beginTransaction();
        try
        {
            $user = $this->user_model::find(LUM_GetDecodeId($request->item_id));
            $user->username = $request->username;
            if ($request->password)
            {
                $user->password = bcrypt($request->password);
            }
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->father_name = $request->father_name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->email_confirmed = $request->email_confirmed;
            $user->mobile_confirmed = $request->mobile_confirmed;
            $user->user_confirmed = $request->user_confirmed;
            $user->save();
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
        DB::beginTransaction();
        try
        {
            $user = new $this->user_model();
            $user->username = $request->username;
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
            $user->save();
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

    public function setUserStatus(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->user_model::find(LUM_GetDecodeId($request->item_id));
            if ($request->is_active == "true")
            {
                $item->user_confirmed = "1";
                $res['message'] = ' آیتم فعال گردید';
            }
            else
            {
                $item->user_confirmed = "0";
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

    public function setEmailStatus(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->user_model::find(LUM_GetDecodeId($request->item_id));
            if ($request->is_active == "true")
            {
                $item->email_confirmed = "1";
                $res['message'] = ' آیتم فعال گردید';
            }
            else
            {
                $item->email_confirmed = "0";
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

    public function setMobileStatus(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $item = $this->user_model::find(LUM_GetDecodeId($request->item_id));
            if ($request->is_active == "true")
            {
                $item->mobile_confirmed = "1";
                $res['message'] = ' آیتم فعال گردید';
            }
            else
            {
                $item->mobile_confirmed = "0";
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

    public function trashUser(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $user = $this->user_model::find(LUM_GetDecodeId($request->item_id));
            $user->delete();
            DB::commit();
            $res =
                [
                    'success' => true,
                    'title'   => "حذف کاربر",
                    'message' => 'کاربر با موفقیت حذف شد.'
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
