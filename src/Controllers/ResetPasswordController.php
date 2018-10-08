<?php

namespace ArtinCMS\LUM\Controllers;

//namespace App\Http\Controllers\Vendor\LUM;

use ArtinCMS\LUM\Mail\RecoveryValidation;
use ArtinCMS\LUM\Models\PasswordReset;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ArtinCMS\LUM\Mail\NewUserValidation;

class ResetPasswordController extends Controller
{
    protected $user_model = '';

    public function __construct(array $settings = [])
    {
        $this->user_model = config('laravel_user_management.user_model');
    }

    public function emailRecovery($message=false)
    {
        return view('laravel_user_management::frontend.auth.email_recovery', compact('message'));
    }

    public function storeRecoveryEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validator = Validator::make($request->all(), $rules, [

            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email'    => 'ایمیل معتبر نمیباشد .',
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
                $user = $this->user_model::where('email', $request->email)->first();
                if ($user)
                {
                    $email_confirmation_code = LUM_generateEmailRandomKey();
                    $expireDate = LUM_nextDate(config('laravel_user_management.expire_date'));
                    $reset = new PasswordReset();
                    $reset->email = $user->email;
                    $reset->token = $email_confirmation_code;
                    $reset->expire_at = $expireDate;
                    $reset->save();
                    $info =
                        [
                            'confirmation_code' => $email_confirmation_code,
                            'email'             => $user->email
                        ];
                    Mail::to($user->email)->queue(new RecoveryValidation($info));
                    $result['success'] = true;
                    $result['message'] = 'برای ادامه به ایمیل خود مراجعه نمایید';
                }
                else
                {
                    $result['success'] = false;
                    $result['errors']['email'] = ['ایمیل موجود نمیباشد .'];

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

    public function resetForm($token)
    {
        $reset = PasswordReset::where('token', $token)->first();
        if ($reset)
        {
            if (time() < strtotime($reset->expire_at) && !$reset->reset_at)
            {
                $user = $this->user_model::where('email',$reset->email)->first() ;
                if ($user)
                {
                    return view('laravel_user_management::frontend.auth.password_recovery', compact('token','user'));
                }
                else
                {
                    abort(404) ;
                }
            }
            else
            {

                return redirect(route('LUM.Recovery.email',['message'=> 'کد تایید شما منقضی شده است لطفا بازیابی رمز عبور را دوباره انجام بدهید .']));
            }
        }
        else
        {
            abort('404');
        }
    }

    public function storeRecoveryPassword(Request $request)
    {
        $rules = [
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $rules, [
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
            $reset = PasswordReset::where('token',$request->token)->first();
            if ($reset)
            {
                $user = $this->user_model::where('email',$reset->email)->first();
                if ($user)
                {
                    if (time() < strtotime($reset->expire_at))
                    {
                        if (!$reset->reset_at)
                        {
                            $reset->reset_at = now() ;
                            $reset->save() ;
                            $user->password = bcrypt($request->password);
                            $user->save() ;
                            $result['success'] = true;
                            $result['href'] = config('laravel_user_management.url_after_recovery_password');
                        }
                        else
                        {
                            $result['success'] = false;
                            $result['errors']['error'] = ['کد تایید مجاز نمیباشد'];
                        }
                    }
                    else
                    {
                        $email_confirmation_code = LUM_generateEmailRandomKey();
                        $expireDate = LUM_nextDate(config('laravel_user_management.expire_date'));
                        $reset->token = $email_confirmation_code;
                        $reset->expire_at = $expireDate;
                        $reset->save();
                        $info =
                            [
                                'confirmation_code' => $email_confirmation_code,
                                'email'             => $reset->email
                            ];
                        Mail::to($reset->email)->queue(new RecoveryValidation($info));
                        $redirect = config('laravel_user_management.activation_url_redirect_func_name')();

                        return redirect($redirect['expired']);
                    }
                }
                else
                {
                    $result['success'] = false;
                    $result['errors']['error'] = ['کد تایید مجاز نمیباشد'];
                }
            }
            else
            {
                $result['success'] = false;
                $result['errors']['error'] = ['کد تایید مجاز نمیباشد'];
            }
            return $result ;

        }
    }

}
