<div class="space-20"></div>
<form class="form-horizontal" name="frm_edit_roles" id="frm_edit_roles" >
    <input type="hidden" name="item_id" id="set_user_id" value="{{$item->encode_id}}">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">نام</span>
        </label>
        <div class="col-sm-6">
            <input name="name" value="{{$item->name}}" class="form-control" id="role_name" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">نام نمایشی</span>
        </label>
        <div class="col-sm-6">
            <input name="display_name"  value="{{$item->display_name}}" class="form-control" id="role_display_name" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="role_description" rows="5">{{$item->description}}</textarea>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ویرایش </button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_edit_roles_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>
