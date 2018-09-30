<div class="space-20"></div>
<form id="frm_edit_users" class="form-horizontal" name="frm_edit_users">
    <input type="hidden" name="item_id" value="{{$item->encode_id}}">
    <form id="frm_edit_users" class="form-horizontal" name="frm_edit_users">
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="username">
                <span class="more_info"></span>
                <span class="label_title">نام کاربری</span>
            </label>
            <div class="col-sm-6">
                <input name="username" value="{{$item->username}}" class="form-control" id="user_username" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="username">
                <span class="more_info"></span>
                <span class="label_title">رمز عبور</span>
            </label>
            <div class="col-sm-6">
                <input type="password" name="password"  value="" class="form-control" id="user_password" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="username">
                <span class="more_info"></span>
                <span class="label_title">رمز عبور</span>
            </label>
            <div class="col-sm-6">
                <input type="password" name="password_confirmation" value="" class="form-control" id="user_password_confirmation" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="title">
                <span class="more_info"></span>
                <span class="label_title">نام</span>
            </label>
            <div class="col-sm-6">
                <input name="first_name" class="form-control" id="role_name" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="title">
                <span class="more_info"></span>
                <span class="label_title">نام خانوادگی</span>
            </label>
            <div class="col-sm-6">
                <input name="last_name" class="form-control" id="user_last_name" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="father_name">
                <span class="more_info"></span>
                <span class="label_title">نام پدر</span>
            </label>
            <div class="col-sm-6">
                <input name="father_name" class="form-control" id="user_father_name" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="father_name">
                <span class="more_info"></span>
                <span class="label_title">ایمیل</span>
            </label>
            <div class="col-sm-6">
                <input name="email" class="form-control" id="user_email" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="mobile">
                <span class="more_info"></span>
                <span class="label_title">موبایل</span>
            </label>
            <div class="col-sm-6">
                <input name="mobile" class="form-control" id="user_mobile" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="mobile">
                <span class="more_info"></span>
                <span class="label_title">آدرس</span>
            </label>
            <div class="col-sm-6">
                <textarea id="user_address" class="field_company_address form-control" name="address" style="text-align: right; direction: rtl;" tab="11"></textarea>
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label col-form-label label_post" for="email_confirmed" style="float: right">
                <span class="more_info"></span>
                <span class="label_title">تایید کاربر</span>
            </label>
            <div class="col-sm-6">
                <label class="radio-inline" data-reg_type="0">
                    <input type="radio" name="user_confirmed" value="0" id="user_confirmed_active" checked/>
                    <span class="form-check-label">غیر فعال</span>
                </label>
                <label class="radio-inline" data-reg_type="1" style="margin-right: 20px;">
                    <input type="radio" name="user_confirmed" value="1" id="user_confirmed_de_active"/>
                    <span class="form-check-label">فعال</span>
                </label>
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label col-form-label label_post" for="email_confirmed" style="float: right">
                <span class="more_info"></span>
                <span class="label_title">تایید ایمیل</span>
            </label>
            <div class="col-sm-6">
                <label class="radio-inline" data-reg_type="0">
                    <input type="radio" name="email_confirmed" value="0" id="email_confirmed_active" checked/>
                    <span class="form-check-label">غیر فعال</span>
                </label>
                <label class="radio-inline" data-reg_type="1" style="margin-right: 20px;">
                    <input type="radio" name="email_confirmed" value="1" id="email_confirmed_de_active"/>
                    <span class="form-check-label">فعال</span>
                </label>
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label col-form-label label_post" for="email_confirmed" style="float: right">
                <span class="more_info"></span>
                <span class="label_title">تایید موبایل</span>
            </label>
            <div class="col-sm-6">
                <label class="radio-inline" data-reg_type="0">
                    <input type="radio" name="mobile_confirmed" value="0" id="mobile_confirmed_active" checked/>
                    <span class="form-check-label">غیر فعال</span>
                </label>
                <label class="radio-inline" data-reg_type="1" style="margin-right: 20px;">
                    <input type="radio" name="mobile_confirmed" value="1" id="mobile_confirmed_de_active"/>
                    <span class="form-check-label">فعال</span>
                </label>
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="clearfixed"></div>
        <div class="col-12">
            <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>اضافه کردن</button>
            <button type="button" class="float-right btn bg-secondary color_white cancel_add_users_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
        </div>
    </form>
</form>
