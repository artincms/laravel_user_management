<div class="space-20"></div>
<form id="frm_edit_permission_categorys" class="form-horizontal" name="frm_edit_permission_categorys">
    <input type="hidden" name="item_id" class="form-control" value="{{$item->encode_id}}" id="edit_permission_category_name" tab="1">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">نام</span>
        </label>
        <div class="col-sm-6">
            <input name="title" class="form-control" value="{{$item->title}}" id="edit_permission_category_name" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">مجموعه والد</span>
        </label>
        <div class="col-sm-6">
            <select name="parent_id" id="edit_permission_category_parent" class="form-control">
                @if($item->parent)
                <option value="{{$item->parent->id}}">{{$item->parent->title}}</option>
                @else
                    <option value="0">انتخاب والد</option>
                @endif
            </select>
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="edit_permission_category_description" rows="5">{{$item->description}}</textarea>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ویرایش کردن</button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_edit_permission_categorys_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>

<script>
    init_select2_ajax('#edit_permission_category_parent', '{{route('LUM.Permissions.autoCompletePermissionCategory')}}');

</script>