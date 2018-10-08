<?php

namespace ArtinCMS\LUM\Controllers;

//namespace App\Http\Controllers\Vendor\LUM;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArtinCMS\LUM\Mail\NewUserValidation;

class LoginController extends Controller
{
    protected $user_model = '';

    public function __construct(array $settings = [])
    {
        $this->user_model = config('laravel_user_management.user_model');
    }

    public function index()
    {
        return view('laravel_user_management::frontend.auth.login', compact('term_url'));
    }

    public function userLogin(Request $request)
    {
        $rules = [
            'username'              => 'required',
            'password'              => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'username.required'              => 'وارد کردن نام کاربری الزامی است.',
            'password.required'              => 'وارد کردن رمزعبور الزامی است.',
            'password.min'                   => 'کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.',
        ]);
        if ($validator->fails())
        {
            $api_errors = validation_error_to_api_json($validator->errors());
            $api_errors = LUM_validation_error_to_api_json($validator->errors());
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
                $username = strtolower($request->username);
                $password = bcrypt($request->password) ;
                if (Auth::attempt(['username' => $username, 'password' => $request->password]))
                {
                    $result['success'] = true;
                }
                elseif (Auth::attempt(['email' => $username, 'password' => $request->password]))
                {
                    $result['success'] = true;
                }
                else
                {
                    $result['success'] = false;
                    $result['errors']['username'] = ['نام کاربری یا کلمه عبور اشتباه است.'];
                }
                if (auth()->check())
                {
                    $result['href'] = config('laravel_user_management.url_after_login');
                    LUM_CreateLogLogin($request,auth()->id());
                }
                else
                {
                    $result['href'] = '#';
                }

                DB::commit();

                return json_encode($result);
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
                    $email_confirmation_code = LUM_generate_email_random_key();
                    $expireDate = LUM_next_date(config('laravel_user_management.expire_date'));
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
