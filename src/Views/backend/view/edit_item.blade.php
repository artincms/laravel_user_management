<div class="space-20"></div>
<form id="frm_edit_gallery_item" class="form-horizontal" name="frm_edit_gallery_item">
    <input type="hidden" value="{{$item->gallery_encode_id}}" name="gallery_id">
    <input type="hidden" value="{{$item->encode_id}}" name="item_id">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">عنوان</span>
        </label>
        <div class="col-sm-6">
            <input name="title" class="form-control" value="{{$item->title}}" id="gallery_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">نوع فایل</label>
        <div class="col-6">
            <select id="gallery_type_edit" name="type" class="form-control">
                <option value="0"  @if($item->type ==0) selected @endif>تصویر</option>
                <option value="1" @if($item->type ==1) selected @endif>صوت</option>
                <option value="2" @if($item->type ==2) selected @endif>ویدئو</option>
            </select>
        </div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">انتخاب تگ</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" multiple id="showSelectTagEditItem" name="tag[]">
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
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="gallery_item_edit_description" rows="3">{{$item->description}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">نوع فایل</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_type_0" name="type" value="0" @if($item->type ==0) checked @endif>تصویر
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_type_1" name="type" value="1" @if($item->type ==1) checked @endif>صوت
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_type_2" name="type" value="2" @if($item->type ==2) checked @endif>ویدئو
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row {{$pic_class}}" id="form_group_picture_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">آپلود فایل</label>
        <div class="col-lg-6 col-sm-12 col-md-5">
            <div class="card bg-light mb-3" style="">
                <div class="card-header">{!! $itmeFile['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeFile['modal_content'] !!}
                    <div id="show_area_medium_item_file_edit">{!! $itmeFileLoad['view']['medium'] !!}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row {{$video_class}}" id="form_group_video_edit">
        <label class="col-lg-2 col-md-3 col-sm-12 control-label col-form-label label_post" for="description">آپلود فایل</label>
        <div class="col-lg-10 col-md-9 col-sm-12 card-deck card_flex_item">
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding" style="">
                <div class="card-header">{!! $itmeVideoMp4File['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeVideoMp4File['modal_content'] !!}
                    <div id="show_area_medium_video_mp4_file">{!! $itmeVideoMp4FileLoad['view']['medium'] !!}</div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeVideoWebmFile['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeVideoWebmFile['modal_content'] !!}
                    <div id="show_area_medium_video_webm_file_edit">{!! $itmeVideoWebmFileLoad['view']['medium'] !!}</div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding" style="">
                <div class="card-header">{!! $itmeVideoOggFile['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeVideoOggFile['modal_content'] !!}
                    <div id="show_area_medium_video_ogg_file_edit">{!! $itmeVideoOggFileLoad['view']['medium'] !!}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row {{$audio_class}}" id="form_group_audio_edit">
        <label class="col-lg-2 col-md-3 col-sm-12 control-label col-form-label label_post" for="description">آپلود فایل</label>
        <div class="col-lg-10 col-md-9 col-sm-12 card-deck card_flex_item">
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeAudioOggFile['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeAudioOggFile['modal_content'] !!}
                    <div id="show_area_medium_audio_ogg_file_edit">{!! $itmeAudioOggFileLoad['view']['medium'] !!}</div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeAudioMp3File['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeAudioMp3File['modal_content'] !!}
                    <div id="show_area_medium_audio_mp3_file_edit">{!! $itmeAudioMp3FileLoad['view']['medium'] !!}</div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeAudioWavFile['button'] !!}</div>
                <div class="card-body">
                    {!! $itmeAudioWavFile['modal_content'] !!}
                    <div id="show_area_medium_audio_wav_file_edit">{!! $itmeAudioWavFileLoad['view']['medium'] !!}</div>
                </div>
            </div>
        </div>
    </div>


    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary cancel_edit_gallery_item_tab color_white"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>

<script>
    function showEdititemFile(res) {
        $('#show_area_medium_item_file_edit').html(res.editItemFile.view.medium);
    }

    function showEditVideoMp4File(res) {
        $('#show_area_medium_video_mp4_file_edit').html(res.editVideoMp4itemFile.view.medium);
    }

    function showEditVideoWebmFile(res) {
        $('#show_area_medium_video_webm_file_edit').html(res.editVideoWebmFile.view.medium);
    }

    function showEditVideoOggFile(res) {
        $('#show_area_medium_video_ogg_file_edit').html(res.editVideoOggFile.view.medium);
    }

    function showEditAudioOggFile(res) {
        $('#show_area_medium_audio_ogg_file_edit').html(res.editAudioOggFile.view.medium);
    }

    function showEditAudioMp3File(res) {
        $('#show_area_medium_audio_mp3_file_edit').html(res.editAudioMp3File.view.medium);
    }

    function showEditAudioWavFile(res) {
        $('#show_area_medium_audio_wav_file_edit').html(res.editAudioWavFile.view.medium);
    }

    $(document).off("change", "#gallery_type_edit");
    $(document).on("change", "#gallery_type_edit", function () {
        show_input_file(this.value);
    });

    function show_input_file(value) {
        if (value == 2) {
            $('#form_group_video_edit').removeClass('hidden');
            $('#form_group_picture_edit').addClass('hidden');
            $('#form_group_audio_edit').addClass('hidden');
        }
        else if (value == 1) {
            $('#form_group_video_edit').addClass('hidden');
            $('#form_group_picture_edit').addClass('hidden');
            $('#form_group_audio_edit').removeClass('hidden');
        }
        else {
            $('#form_group_video_edit').addClass('hidden');
            $('#form_group_picture_edit').removeClass('hidden');
            $('#form_group_audio_edit').addClass('hidden');
        }
    }
    $('#gallery_item_edit_description').summernote({
        height: 200,
    } );
    init_select2_ajax('#showSelectTagEditItem', '{{route('LTS.autoCompleteTag')}}', true,true);
    init_select2_data('#GallerySelectLangEditItem',{!! $multiLang !!});


</script>

