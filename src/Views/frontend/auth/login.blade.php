@extends('laravel_user_management::layouts.frontend_master')

@section('content')
    <div id="form_message_box"></div>
    <div class="show_register_form">
        <form  id="frm_user_login" class="form-horizontal" name="frm_user_login">
            <div class="panel panel-body login-form">
                <div class="text-center">
                    <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                    <h5 class="content-group">ورود کاربران</h5>
                </div>
                <div class="form-group has-feedback has-feedback-left">
                    <input type="text" name="username" class="form-control" placeholder="نام کاربری">
                    <div class="form-control-feedback">
                        <i class="icon-user-check text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>

                <div class="form-group has-feedback has-feedback-left">
                    <input type="password" class="form-control" name="password" placeholder="رمز عبور">
                    <div class="form-control-feedback">
                        <i class="icon-user-lock text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>
                <button type="submit" class="btn bg-teal btn-block btn-lg">ورود<i class="icon-circle-left2 position-right"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('inline_js')
    @include('laravel_user_management::frontend.auth.helper.login.inline_js')
@endsection
