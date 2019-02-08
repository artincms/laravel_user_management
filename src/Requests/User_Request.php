<?php

namespace ArtinCMS\LUM\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class User_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roles =
            [
                // Person
                'first_name'            => 'required|min:2|max:60',
                'last_name'             => 'required|min:2|max:60',
                'email'                 => 'required|email||unique:'.config('laravel_user_management.user_table').',email,NULL,id,deleted_at,NULL',
                'username'              => 'required|alpha_num|min:5|max:20|unique:'.config('laravel_user_management.user_table').',username,NULL,id,deleted_at,NULL',
                'password'              => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
            ];
        if ($this->request->get('melli_code'))
        {
            $codemeli = [
                'melli_code' => 'required|melli_code|unique:'.config('laravel_user_management.user_table').',melli_code,NULL,id,deleted_at,NULL',
            ];
        }
        else
        {
            $codemeli = [];
        }
        $roles = array_merge($roles,$codemeli);
        return $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $api_errors = LUM_validation_error_to_api_json($validator->errors());
        if ($validator->errors()->first('register_captcha_code'))
        {
            $res =
                [
                    'success'      => false,
                    'status_type' => "error",
                    'errors'      => ['کد'],
                    'message'     => [['title' => 'لطفا موارد زیر را بررسی نمایید:', 'items' => ['کد امنیتی صحیح نمی‌باشد.']]]
                ];
            throw new HttpResponseException(
                response()
                    ->json($res, 200)
                    ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
            );
        }
        else
        {
            $res =
                [
                    'success'      => false,
                    'status_type' => "error",
                    'errors'      => $api_errors,
                    'message'     => [['title' => 'لطفا موارد زیر را بررسی نمایید:', 'items' => $api_errors]]
                ];
        }

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function messages()
    {
        return [
            // Person
            'first_name.required'                    => 'نام الزامی است',
            'first_name.min'                         => 'نام باید حداقل 2 کاراکتر باشد.',
            'first_name.max'                         => 'نام حداکثر می‌تواند 60 کاراکتر باشد.',
            'last_name.required'                     => 'وارد کردن نام خانوادگی الزامی است.',
            'last_name.min'                          =>'نام خانوادگی باید حداقل 2 کاراکتر باشد.',
            'last_name.max'                          =>  'نام خانوادگی نمی‌تواند بیشتر از 60 کاراکتر باشد.',
            'mobile.iran_mobile_phone'               => 'شماره همراه وارد شده صحیح نمی باشد.',
            'email.required'                         =>  'وارد کردن ایمیل الزامی است.',
            'email.email'                            =>  'ایمیل وارد شده معتبر نمی باشد.',
            'email.unique'                           => 'ایمیل وارد شده قبلا در سامانه ثبت شده است.',
            'username.required'                      =>  'وارد کردن نام کاربری الزامی است.',
            'username.min'                           => 'نام کاربری نمی‌تواند کمتر از 5 کاراکتر باشد.',
            'username.max'                           => 'نام کاربری نمی‌تواند بیشتر از 20 کاراکتر باشد.',
            'username.unique'                        =>'نام کاربری وارد شده قبلا در سامانه ثبت شده است.',
            'password.required'                      => 'وارد کردن رمزعبور الزامی است.',
            'password.confirmed'                     => 'تکرار رمز عبور با رمز عبور وارد شده یکسان نیست.',
            'password.min'                           => 'کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.',
            'password_confirmation.required'         =>'وارد کردن تکرار کلمه عبور الزامی است.',
            'password_confirmation.min'              => 'تکرار کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.',
            'melli_code.unique'                           => 'کد ملی وارد شده قبلا در سامانه ثبت شده است.',
        ];
    }
}
