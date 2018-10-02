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
                <input name="first_name" value="{{$item->first_name}}" class="form-control" id="role_name" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="title">
                <span class="more_info"></span>
                <span class="label_title">نام خانوادگی</span>
            </label>
            <div class="col-sm-6">
                <input name="last_name" value="{{$item->last_name}}" class="form-control" id="user_last_name" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="father_name">
                <span class="more_info"></span>
                <span class="label_title">نام پدر</span>
            </label>
            <div class="col-sm-6">
                <input name="father_name" value="{{$item->father_name}}" class="form-control" id="user_father_name" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="father_name">
                <span class="more_info"></span>
                <span class="label_title">ایمیل</span>
            </label>
            <div class="col-sm-6">
                <input name="email" value="{{$item->email}}" class="form-control" id="user_email" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="mobile">
                <span class="more_info"></span>
                <span class="label_title">موبایل</span>
            </label>
            <div class="col-sm-6">
                <input name="mobile" value="{{$item->mobile}}" class="form-control" id="user_mobile" tab="1">
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="form-group row fg_title">
            <label class="col-sm-2 control-label col-form-label label_post" for="mobile">
                <span class="more_info"></span>
                <span class="label_title">آدرس</span>
            </label>
            <div class="col-sm-6">
                <textarea id="user_address" class="field_company_address form-control" name="address" style="text-align: right; direction: rtl;" tab="11">{{$item->address}}</textarea>
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
                    <input type="radio" name="user_confirmed" value="0" id="user_confirmed_active" @if($item->user_confirmed == 0) checked @endif/>
                    <span class="form-check-label">غیر فعال</span>
                </label>
                <label class="radio-inline" data-reg_type="1" style="margin-right: 20px;">
                    <input type="radio" name="user_confirmed" value="1" id="user_confirmed_de_active"  @if($item->user_confirmed == 1) checked @endif/>
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
                    <input type="radio" name="email_confirmed" value="0" id="email_confirmed_active" @if($item->email_confirmed == 0) checked @endif/>
                    <span class="form-check-label">غیر فعال</span>
                </label>
                <label class="radio-inline" data-reg_type="1" style="margin-right: 20px;">
                    <input type="radio" name="email_confirmed" value="1" id="email_confirmed_de_active" @if($item->email_confirmed == 1) checked @endif/>
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
                    <input type="radio" name="mobile_confirmed" value="0" id="mobile_confirmed_active" @if($item->mobile_confirmed == 0) checked @endif/>
                    <span class="form-check-label">غیر فعال</span>
                </label>
                <label class="radio-inline" data-reg_type="1" style="margin-right: 20px;">
                    <input type="radio" name="mobile_confirmed" value="1" id="mobile_confirmed_de_active" @if($item->mobile_confirmed == 1) checked @endif/>
                    <span class="form-check-label">فعال</span>
                </label>
            </div>
            <div class="col-sm-4 messages"></div>
        </div>
        <div class="clearfixed"></div>
        <div class="col-12">
            <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ویرایش</button>
            <button type="button" class="float-right btn bg-secondary color_white cancel_edit_user_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
        </div>
    </form>
</form>

<script>
    var frm_edit_users = document.querySelector("#frm_edit_users");
    var edit_users_constraints = {
        username: {
            presence: {message: '^<strong>نام کاربری ضروری است.</strong>'},
            length: {minimum: 5, message: '^<strong>نام کاربری نمی‌تواند کمتر از 5 کاراکتر باشد.</strong>'},
            length: {maximum: 20, message: '^<strong>نام کاربری نمی‌تواند بیشتر از 20 کاراکتر باشد.</strong>'}
        },
        first_name: {
            presence: {message: '^<strong>نام ضروری است.</strong>'},
            length: {minimum: 2, message: '^<strong>نام  نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام نمی‌تواند بیشتر از 60 کاراکتر باشد.</strong>'}
        },
        last_name: {
            presence: {message: '^<strong>نام خانوادگی ضروری است.</strong>'},
            length: {minimum: 2, message: '^<strong>نام خانوادگی  نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام خانوادگی نمی‌تواند بیشتر از 60 کاراکتر باشد.</strong>'}
        },
        email: {
            presence: {message: '^<strong>وارد کردن ایمیل الزامی است.</strong>'},
            email: {message: '^<strong>ایمیل وارد شده معتبر نمی باشد.</strong>'}
        },
        mobile: {
            iranMobileNumber: {message: '^<strong>شماره همراه وارد شده صحیح نمی باشد.</strong>'},
            length: {maximum: 11, message: '^<strong>شماره همراه نمی‌تواند بیشتر از 11 کاراکتر باشد.</strong>'}
        },
        password: {

        },
        password_confirmation: {
            equality: {
                attribute: "password",
                message: '^<strong>تکرار رمز عبور با رمز عبور وارد شده یکسان نیست.</strong>',
                comparator: function (v1, v2) {
                    return JSON.stringify(v1) === JSON.stringify(v2);
                }
            }
        },
    };
    init_validatejs(frm_edit_users, edit_users_constraints, ajax_func_edit_users);
    function ajax_func_edit_users(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Users.editUser')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_edit_users .total_loader').remove();
                if (data.success) {
                    clear_form_elements('#frm_edit_users');
                    menotify('success', data.title, data.message);
                    UsersGridData.ajax.reload(null, false);
                    $('a[href="#manage_user"]').click();
                    $('.edit_user_tab').addClass('hidden');
                    $('#edit_user').html('');
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
    }
    $(document).off("click", ".cancel_edit_user_btn");
    $(document).on("click", ".cancel_edit_user_btn", function () {
        $('a[href="#manage_user"]').click();
        $('.edit_user_tab').addClass('hidden');
        $('#edit_user').html('');
    });
</script>
