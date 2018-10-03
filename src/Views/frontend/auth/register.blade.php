@extends('laravel_user_management::layouts.frontend_master')

@section('content')
    <div class="show_activation_message alert alert-success hidden"></div>
    <div id="form_message_box"></div>
    <div class="show_register_form">
        <form  id="frm_user_register" class="form-horizontal" name="frm_user_register">
            <div class="panel panel-body login-form">
                <div class="text-center">
                    <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                    <h5 class="content-group">ثبت نام کاربران</h5>
                </div>
                <div class="content-divider text-muted form-group"><span>اطلاعات ثبت نام</span></div>

                <div class="form-group has-feedback has-feedback-left">
                    <input type="text" name="username" class="form-control" placeholder="نام کاربری">
                    <div class="form-control-feedback">
                        <i class="icon-user-check text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>

                <div class="form-group has-feedback has-feedback-left">
                    <input type="password" class="form-control" name="password" placeholder="گذرواژه">
                    <div class="form-control-feedback">
                        <i class="icon-user-lock text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>
                <div class="form-group has-feedback has-feedback-left">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="تایید گذرواژه">
                    <div class="form-control-feedback">
                        <i class="icon-user-lock text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>


                {{--<div class="content-divider text-muted form-group"><span>اطلاعات شخصی</span></div>--}}

                <div class="form-group has-feedback has-feedback-left">
                    <input type="text" class="form-control" name="email" placeholder="ایمیل">
                    <div class="form-control-feedback">
                        <i class="icon-mention text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>
                <div class="content-divider text-muted form-group"><span>قوانین</span></div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="styled" name="rules">
                            قبول <a href="{{$term_url}}">قوانین </a>سایت
                        </label>
                        <span class="help-block text-danger messages"></span>
                    </div>
                </div>

                <button type="submit" class="btn bg-teal btn-block btn-lg">ثبت نام <i class="icon-circle-left2 position-right"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('inline_js')
    @include('laravel_user_management::frontend.auth.helper.register.inline_js')
@endsection
