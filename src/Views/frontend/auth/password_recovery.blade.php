@extends('laravel_user_management::layouts.frontend_master')

@section('content')
    <div id="form_message_box"></div>
    <div class="show_success_message alert alert-success hidden"></div>
    <div class="show_register_form">
        <form  id="frm_recovery_password" class="form-horizontal" name="frm_recovery_password">
            <input type="hidden" name="token" value="{{$token}}">
            <div class="panel panel-body login-form" style="width: 415px">
                <div class="text-center">
                    <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
                    <h5 class="content-group">بازیابی رمز عبور</h5>
                </div>
                <div class="form-group has-feedback has-feedback-left row">
                   <div class="field_title col-md-4"><i class="icon-user text-muted"></i><span> نام کاربری</span></div>
                   <div class="field_value col-md-8">{{$user->username}}</div>
                </div>
                <div class="form-group has-feedback has-feedback-left row">
                    <div class="field_title col-md-4"><i class="icon-mail5 text-muted"></i><span>ایمیل </span></div>
                    <div class="field_value col-md-8">{{$user->email}}</div>
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
                <div class="form-group has-feedback has-feedback-left">
                    <input type="hidden" name="error">
                    <span class="help-block text-danger messages"></span>
                </div>
                <button type="submit" class="btn bg-teal btn-block btn-lg"><i class="icon-arrow-left13 position-right"></i><span style="margin-right: 5px;">بازیابی رمز عبور</span></button>
            </div>
        </form>
    </div>
@endsection

@section('inline_js')
    @include('laravel_user_management::frontend.auth.helper.recovery.inline_js_recovery_password')
@endsection
