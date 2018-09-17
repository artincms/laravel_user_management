<div class="space-20"></div>
<form id="frm_edit_gallery" class="form-horizontal" name="frm_create_gallery">
    <input type="hidden" name="item_id" value="{{$gallery->encode_id}}">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">عنوان</span>
        </label>
        <div class="col-sm-6">
            <input name="title" value="{{$gallery->title}}" class="form-control" id="gallery_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="gallery_eidt_description" rows="3">{!! $gallery->description !!}</textarea>
        </div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">انتخاب تگ</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" multiple id="showSelectTagEdit" name="tag[]">
                @if($tags)
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" selected>{{$tag->title}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">گالری والد</label>
        <div class="col-6">
            <select name="parent_id" id="gallery_parrent_edit" class="form-control">
                <option value="0">بدون والد</option>
                @foreach($parrents_edit as $parrent)
                    <option value="{{$parrent->id}}" @if($gallery->parent_id ==$parrent->id) selected @endif>{{$parrent->text}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if($multiLang)
    <div class="form-group row fg_lang" id="showLangCategoryEdit">
        <label class="col-sm-2 control-label col-form-label label_post" for="lang">
            <span class="more_info"></span>
            <span class="label_lang">انتخاب زبان</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" name="lang_id" id="FaqSelectLangEdit">
                <option value="{{$gallery->lang_id}}" value="-1">{{$active_lang_title}}</option>
            </select>
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    @endif
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
        <div class="col-6">
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_is_active1" name="is_active" value="1"  @if($gallery->is_active ==1) checked @endif>فعال
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_is_active2" name="is_active" value="0"  @if($gallery->is_active ==0) checked @endif>غیر فعال
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب تصویر پیش فرض</label>
            <div class="col-lg-6 col-sm-12 col-md-5">
                <div class="card bg-light mb-3" style="">
                    <div class="card-header">{!! $default_img['button'] !!}</div>
                    <div class="card-body">
                        {!! $default_img['modal_content'] !!}
                        <div id="show_area_medium_load_default_img">{!! $load_default_img['view']['medium'] !!}</div>
                    </div>
                </div>
            </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_edit_gallery"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>
<script>
    change_lang_field();
    function showDefaultImg(res) {
        $('#show_area_medium_load_default_img').html(res.LoadDefaultImg.view.medium) ;
    }
    init_select2_data('#gallery_parrent_edit',{!! $parrents_edit !!});
    $('#gallery_eidt_description').summernote({
        height: 150,
    } );
    init_select2_ajax('#showSelectTagEdit', '{{route('LTS.autoCompleteTag')}}', true,true);
    init_select2_data('#FaqSelectLangEdit',{!! $multiLang !!});

    $('#gallery_parrent_edit').off("select2:select");
    $('#gallery_parrent_edit').on("select2:select", change_lang_field);
    function change_lang_field() {
        var parent_id = $('#gallery_parrent_edit').val();
        if(parent_id !=0)
        {
            $('#showLangCategoryEdit').hide();
        }
        else
        {
            $('#showLangCategoryEdit').show();
        }
    }

</script>

