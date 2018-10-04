<?php

namespace ArtinCMS\LUM\Controllers;

//namespace App\Http\Controllers\Vendor\LUM;

use App\Permission;
use ArtinCMS\LUM\Models\PermissionCategoryManagement;
use DB;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArtinCMS\LUM\Mail\NewUserValidation;

class RegisterController extends Controller
{
    protected $user_model = '';

    public function __construct(array $settings = [])
    {
        $this->user_model = config('laravel_user_management.user_model');
    }

    public function index()
    {
//        $permissions = PermissionCategoryManagement::where('id','>',0)->get();
//        foreach ($permissions as $permission)
//        {        $permission->delete();
//
//        }
        $term_url = config('laravel_user_management.accept_term_url');

        return view('laravel_user_management::frontend.auth.register', compact('term_url'));
    }

    public function addRegister(Request $request)
    {
        $rules = [
            'email'                 => 'required|email||unique:lum_users,email,NULL,id,deleted_at,NULL',
            'username'              => 'required|min:5|max:20|unique:lum_users,username,NULL,id,deleted_at,NULL|valid_username',
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'email.required'                 => 'وارد کردن ایمیل الزامی است.',
            'email.email'                    => 'ایمیل وارد شده معتبر نمی باشد.',
            'email.unique'                   => 'ایمیل وارد شده قبلا در سامانه ثبت شده است.',
            'username.required'              => 'وارد کردن نام کاربری الزامی است.',
            'username.min'                   => 'نام کاربری نمی‌تواند کمتر از 5 کاراکتر باشد.',
            'username.valid_username'        => 'نام کاربری معتبر نمیباشد .',
            'username.max'                   => 'نام کاربری نمی‌تواند بیشتر از 20 کاراکتر باشد.',
            'username.unique'                => 'نام کاربری وارد شده قبلا در سامانه ثبت شده است.',
            'username.regex'                 => 'نام کاربری فقط باید شامل حروف انگلیسی کوچک و اعداد و نقطه آندرلاین باشد .',
            'password.required'              => 'وارد کردن رمزعبور الزامی است.',
            'password.confirmed'             => 'تکرار رمز عبور با رمز عبور وارد شده یکسان نیست.',
            'password.min'                   => 'کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.',
            'password_confirmation.required' => 'وارد کردن تکرار کلمه عبور الزامی است.',
            'password_confirmation.min'      => 'تکرار کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.',
        ]);
        if ($validator->fails())
        {
            $api_errors = validation_error_to_api_json($validator->errors());
            $res =
                [
                    'success' => false,
                    'errors'  => $api_errors,
                    'message' => [['title' => 'لطفا موارد زیر را بررسی نمایید:', 'items' => $api_errors]]
                ];

            return json_encode($res);

        }
        else
        {
            DB::beginTransaction();
            try
            {
                $email_confirmation_code = LUM_generateEmailRandomKey();
                $expireDate = LUM_nextDate(config('laravel_user_management.expire_date'));
                $username = $request->username;
                $email = $request->email;
                if ($username)
                {
                    $username = str_replace(' ', '', $username);
                    $username = strtolower($username);
                }
                if ($email)
                {
                    $email = str_replace(' ', '', $email);
                    $email = strtolower($email);
                }
                $user = new $this->user_model();
                $user->username = $username;
                $user->password = bcrypt($request->password);
                $user->email = $request->email;
                $user->email_confirmation_code = $email_confirmation_code;
                $user->email_confirmation_code_expire_at = $expireDate;
                $user->save();
                $res =
                    [
                        'success' => true,
                        'title'   => "اضافه کردن کاربر",
                        'message' => 'کاربر با موفقیت اضافه شد .'
                    ];

                if (config('laravel_user_management.the_email_must_be_checked'))
                {
                    $info =
                        [
                            'confirmation_code' => $email_confirmation_code,
                            'email'             => $user->email
                        ];
                    Mail::to($user->email)->queue(new NewUserValidation($info));
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
    }

    public function activationUser($code)
    {
        if ($code)
        {
            $user = $this->user_model::where('email_confirmation_code', $code)->first();
            if ($user)
            {
                if (time() < strtotime($user->email_confirmation_code_expire_at))
                {
                    $user->email_confirmed = '1';
                    $user->email_verified_at = date('Y-m-d H:i:s');
                    $user->save();
                    if (config('laravel_user_management.activation_url_redirect_func_name'))
                    {
                        $redirect = config('laravel_user_management.activation_url_redirect_func_name')();

                        return redirect($redirect['successed']);
                    }
                    else
                    {
                        abort(500);
                    }
                }
                else
                {
                    $email_confirmation_code = LUM_generateEmailRandomKey();
                    $expireDate = LUM_nextDate(config('laravel_user_management.expire_date'));
                    $user->email_confirmation_code = $email_confirmation_code;
                    $user->email_confirmation_code_expire_at = $expireDate;
                    $user->save();
                    if (config('laravel_user_management.the_email_must_be_checked'))
                    {
                        $info =
                            [
                                'confirmation_code' => $email_confirmation_code,
                                'email'             => $user->email
                            ];
                        Mail::to($user->email)->queue(new NewUserValidation($info));
                    }

                    $redirect = config('laravel_user_management.activation_url_redirect_func_name')();

                    return redirect($redirect['expired']);
                }
            }
            else
            {
                $redirect = config('laravel_user_management.activation_url_redirect_func_name')();

                return redirect($redirect['failed']);
            }
            dd($user->toArray());
        }
        else
        {
            abort(500);
        }
        dd($code);
    }

    public function failedActivation()
    {
        return view('laravel_user_management::frontend.activation.failed_activation');
    }

    public function successedActivation()
    {
        return view('laravel_user_management::frontend.activation.success_activation');
    }

    public function expiredActivation()
    {
        return view('laravel_user_management::frontend.activation.expired_activation_code');
    }
}
