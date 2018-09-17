@extends('laravel_user_management::layouts.backend_master')
@section('page_title')
    Laravel User Manager
@stop
@section('custom_plugin_js')
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header text-center">مدیریت کاربران</div>
            <div class="card-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-bottom" id="user_tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#manage_tab" data-toggle="tab"><i class="fas fa-th-list"></i><span class="margin_right_5">مدیریت کاربران</span></a></li>
                        <li class="nav-item roles_manager_tab">
                            <a class="nav-link" href="#roles_manager" data-toggle="tab">
                                <i class="far fa-plus-square"></i>
                                <span>مدیریت نقش ها</span>
                            </a>
                        </li>
                        <li class="nav-item permissin_manager_tab">
                            <a class="nav-link" href="#permissin_manager" data-toggle="tab">
                                <i class="far fa-plus-square"></i>
                                <span>مدیریت دسترسی ها</span>
                            </a>
                        </li>
                        <li class="nav-item login_history_tab">
                            <a class="nav-link" href="#login_history" data-toggle="tab">
                                <i class="far fa-plus-square"></i>
                                <span>تاریخچه ورود</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="manage_tab">
                            <div class="space-20"></div>
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-bottom" id="user_tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#manage_tab_user_item" data-toggle="tab">
                                            <i class="fas fa-th-list"></i>
                                            <span class="margin_right_5">مدیریت</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="add_user_tab">
                                        <a class="nav-link" href="#add_user" data-toggle="tab">
                                            <i class="far fa-plus-square"></i>
                                            <span>افزودن کاربر</span>
                                        </a>
                                    </li>
                                    <li class="nav-item edit_user_tab hidden">
                                        <a href="#edit_user_item" class="nav-link paddin_left_30" data-toggle="tab">
                                            <span class="span_edit_user_tab">ویرایش</span>
                                        </a>
                                        <button class="close closeTab cancel_edit_user_tab" type="button">×</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="manage_tab_user">
                                        <div>
                                            <div class="space-20"></div>
                                            <div class="col-xs-12 user_manager_parrent_div">
                                                <table id="UsersGridData" class="table " width="100%"></table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="add_user"></div>
                                    <div class="tab-pane" id="edit_user_item"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="roles_manager">
                            <div class="space-20"></div>
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-bottom" id="role_tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#manage_tab_role_item" data-toggle="tab">
                                            <i class="fas fa-th-list"></i>
                                            <span class="margin_right_5">مدیریت</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="add_role_tab">
                                        <a class="nav-link" href="#add_role" data-toggle="tab">
                                            <i class="far fa-plus-square"></i>
                                            <span>افزودن نقش</span>
                                        </a>
                                    </li>
                                    <li class="nav-item edit_role_tab hidden">
                                        <a href="#edit_role_item" class="nav-link paddin_left_30" data-toggle="tab">
                                            <span class="span_edit_role_tab">ویرایش</span>
                                        </a>
                                        <button class="close closeTab cancel_edit_role_tab" type="button">×</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="manage_tab_role">
                                        <div>
                                            <div class="space-20"></div>
                                            <div class="col-xs-12 role_manager_parrent_div">
                                                <table id="RolesGridData" class="table " width="100%"></table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="add_role">
                                        <div class="space-20"></div>
                                        <form id="frm_create_roles" class="form-horizontal" name="frm_create_roles">
                                            <div class="form-group row fg_title">
                                                <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                    <span class="more_info"></span>
                                                    <span class="label_title">نام</span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <input name="name" class="form-control" id="role_name" tab="1">
                                                </div>
                                                <div class="col-sm-4 messages"></div>
                                            </div>
                                            <div class="form-group row fg_title">
                                                <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                    <span class="more_info"></span>
                                                    <span class="label_title">نام نمایشی</span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <input name="display_name" class="form-control" id="role_display_name" tab="1">
                                                </div>
                                                <div class="col-sm-4 messages"></div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
                                                <div class="col-6">
                                                    <textarea class="form-control" name="description" id="role_description" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="clearfixed"></div>
                                            <div class="col-12">
                                                <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>اضافه کردن</button>
                                                <button type="button" class="float-right btn bg-secondary color_white cancel_add_roles_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="edit_role_item"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="permissin_manager"></div>
                        <div class="tab-pane" id="login_history"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('inline_js')
    @include('laravel_user_management::backend.helper.index.inline_js')
    @include('laravel_user_management::backend.helper.index.inline_js_roles')
@stop