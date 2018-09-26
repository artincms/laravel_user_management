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
                        <li class="nav-item"><a class="nav-link active" href="#manage_tab" data-toggle="tab"><i class="fas fa-users-cog"></i><span class="margin_right_5">مدیریت کاربران</span></a></li>
                        <li class="nav-item roles_manager_tab">
                            <a class="nav-link" href="#roles_manager" data-toggle="tab">
                                <i class="fas fa-users-cog"></i>
                                <span>مدیریت نقش ها</span>
                            </a>
                        </li>
                        <li class="nav-item permissin_category_manager_tab">
                            <a class="nav-link" href="#permissin_category_manager" data-toggle="tab">
                                <i class="fas fa-users-cog"></i>
                                <span>مدیریت دسترسی ها</span>
                            </a>
                        </li>
                        <li class="nav-item set_permissions_tab_tab">
                            <a class="nav-link" href="#set_permissions" data-toggle="tab">
                                <i class="fas fa-cog"></i>
                                <span class="set_permissions_span">انتصاب دسترسی</span>
                            </a>
                        </li>
                        <li class="nav-item login_history_tab"  style="position: absolute;left: 0px;">
                            <a class="nav-link" href="#login_history" data-toggle="tab">
                                <span>تاریخچه ورود</span>
                                <i class="fas fa-history"></i>
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
                                        <a class="nav-link active" href="#manage_tab_role" data-toggle="tab">
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
                                        <a href="#edit_role" class="nav-link paddin_left_30" data-toggle="tab">
                                            <span class="span_edit_role_tab">ویرایش</span>
                                        </a>
                                        <button class="close closeTab cancel_edit_roles_btn" type="button">×</button>
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
                                    <div class="tab-pane" id="edit_role"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="permissin_category_manager">
                            <div class="space-20"></div>
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-bottom" id="permission_category_tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#manage_tab_permission_category" data-toggle="tab">
                                            <i class="fas fa-th-list"></i>
                                            <span class="margin_right_5">مدیریت</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="add_permission_category_tab">
                                        <a class="nav-link" href="#add_permission_category" data-toggle="tab">
                                            <i class="far fa-plus-square"></i>
                                            <span>افزودن دسته بندی</span>
                                        </a>
                                    </li>
                                    <li class="nav-item edit_permission_category_tab hidden">
                                        <a href="#edit_permission_category" class="nav-link paddin_left_30" data-toggle="tab">
                                            <span class="span_edit_permission_category_tab">ویرایش</span>
                                        </a>
                                        <button class="close closeTab cancel_edit_permission_categorys_btn" type="button">×</button>
                                    </li>
                                    <li class="nav-item permissin_manager_tab hidden">
                                        <a href="#permissin_manager" class="nav-link paddin_left_30" data-toggle="tab">
                                            <span class="span_permissin_manager_tab">دسترسی</span>
                                        </a>
                                        <button class="close closeTab cancel_add_permission_btn" type="button">×</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="manage_tab_permission_category">
                                        <div>
                                            <div class="space-20"></div>
                                            <div class="col-xs-12 permission_category_manager_parrent_div">
                                                <table id="PermissionCategorysGridData" class="table " width="100%"></table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="add_permission_category">
                                        <div class="space-20"></div>
                                        <form id="frm_create_permission_categorys" class="form-horizontal" name="frm_create_permission_categorys">
                                            <div class="form-group row fg_title">
                                                <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                    <span class="more_info"></span>
                                                    <span class="label_title">نام</span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <input name="title" class="form-control" id="permission_category_name" tab="1">
                                                </div>
                                                <div class="col-sm-4 messages"></div>
                                            </div>
                                            <div class="form-group row fg_title">
                                                <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                    <span class="more_info"></span>
                                                    <span class="label_title">مجموعه والد</span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <select name="parent_id" id="permission_category_parrent" class="form-control">
                                                        <option value="0">بدون والد</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 messages"></div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
                                                <div class="col-6">
                                                    <textarea class="form-control" name="description" id="permission_category_description" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="clearfixed"></div>
                                            <div class="col-12">
                                                <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>اضافه کردن</button>
                                                <button type="button" class="float-right btn bg-secondary color_white cancel_add_permission_categorys_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="edit_permission_category"></div>
                                    <div class="tab-pane" id="permissin_manager">
                                        <div class="space-20"></div>
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs nav-tabs-bottom" id="permission_tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#manage_tab_permission" data-toggle="tab">
                                                        <i class="fas fa-th-list"></i>
                                                        <span class="margin_right_5">مدیریت</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item" id="add_permission_tab">
                                                    <a class="nav-link" href="#add_permission" data-toggle="tab">
                                                        <i class="far fa-plus-square"></i>
                                                        <span>افزودن دسترسی</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item edit_permission_tab hidden">
                                                    <a href="#edit_permission" class="nav-link paddin_left_30" data-toggle="tab">
                                                        <span class="span_edit_permission_tab">ویرایش</span>
                                                    </a>
                                                    <button class="close closeTab cancel_edit_permissions_btn" type="button">×</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="manage_tab_permission">
                                                    <div>
                                                        <div class="space-20"></div>
                                                        <div class="col-xs-12 permission_manager_parrent_div">
                                                            <table id="PermissionsGridData" class="table " width="100%"></table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="add_permission">
                                                    <div class="space-20"></div>
                                                    <form id="frm_create_permissions" class="form-horizontal" name="frm_create_permissions">
                                                        <input type="hidden" name="category_id" id="hidden_permission_category_id">
                                                        <div class="form-group row fg_title">
                                                            <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                                <span class="more_info"></span>
                                                                <span class="label_title">نام</span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input name="name" class="form-control" id="permission_name" tab="1">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <div class="form-group row fg_title">
                                                            <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                                <span class="more_info"></span>
                                                                <span class="label_title">نام نمایشی</span>
                                                            </label>
                                                            <div class="col-sm-6">
                                                                <input name="display_name" class="form-control" id="permission_display_name" tab="1">
                                                            </div>
                                                            <div class="col-sm-4 messages"></div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
                                                            <div class="col-6">
                                                                <textarea class="form-control" name="description" id="permission_description" rows="5"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="clearfixed"></div>
                                                        <div class="col-12">
                                                            <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>اضافه کردن</button>
                                                            <button type="button" class="float-right btn bg-secondary color_white cancel_add_permissions_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="edit_permission"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="set_permissions">
                            <div class="space-20"></div>
                            <div class="title_permissino col-md-6 float-left" style="font-size: 18px;font-weight: bold;">
                                انتصاب دسترسی به
                            </div>
                            <form id="frm_set_permission" class="form-horizontal" name="frm_set_permission">
                                <input type="hidden" name="set_permission_id" id="set_permission_id" value="">
                                <input type="hidden" name="permission_type" id="permission_type" value="">
                                <div class="show_permissions">
                                    <ul id="ul_show_permissions">
                                        {!! $permissions !!}
                                    </ul>
                                </div>
                            </form>
                        </div>
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
    @include('laravel_user_management::backend.helper.index.inline_js_permissiones')
@stop