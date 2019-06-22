@extends('laravel_user_management::layouts.frontend_master')

@section('content')
    <div id="form_message_box">@if($message) <div class="alert alert-danger">{{$message}}</div>  @endif</div>
    <div class="show_success_message alert alert-success hidden"></div>
    <div class="show_register_form">
        <form  id="frm_recovery_email" class="form-horizontal" name="frm_user_login">
            <div class="panel panel-body login-form">
                <div class="text-center">
                    <div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
                    <h5 class="content-group">بازیابی رمز عبور</h5>
                </div>
                <div class="form-group has-feedback has-feedback-left">
                    <input type="email" name="email" class="form-control" placeholder="ایمیل">
                    <div class="form-control-feedback">
                        <i class="icon-mail5 text-muted"></i>
                    </div>
                    <span class="help-block text-danger messages"></span>
                </div>
                <button type="submit" class="btn bg-teal btn-block btn-lg"><i class="icon-arrow-left13 position-right"></i><span style="margin-right: 5px;">بازیابی رمز عبور</span></button>
            </div>
        </form>
    </div>
@endsection

@section('inline_js')
    @include('laravel_user_management::frontend.auth.helper.recovery.inline_js_recovery_email')
@endsection
