<div class="space-20"></div>
<form id="frm_edit_permissions" class="form-horizontal" name="frm_edit_permissions">
    <input type="hidden" name="item_id" class="form-control" value="{{$item->encode_id}}" id="permission_name" tab="1">
    <input type="hidden" name="category_id" class="form-control" value="{{$item->category_encode_id}}" id="permission_name" tab="1">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">نام</span>
        </label>
        <div class="col-sm-6">
            <input name="name" class="form-control" value="{{$item->name}}" id="edit_permission_name" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">نام نمایشی</span>
        </label>
        <div class="col-sm-6">
            <input name="display_name" class="form-control" value="{{$item->display_name}}" id="edit_permission_display_name" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="edit_permission_description" rows="5">{{$item->description}}</textarea>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ویرایش کردن</button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_edit_permissions_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>

<script>

</script>