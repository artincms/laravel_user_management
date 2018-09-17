<div class="space-20"></div>
<form id="frm_create_gallery_item" class="form-horizontal" name="frm_create_gallery">
    <input type="hidden" value="{{$gallery_id}}" name="gallery_id">
    <div class="form-group row fg_title">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">عنوان</span>
        </label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <input name="title" class="form-control" id="gallery_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">انتخاب تگ</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" multiple id="showSelectTagItem" name="tag[]">
            </select>
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <textarea class="form-control" name="description" id="gallery_item_description" rows="3"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">نوع فایل</label>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_type_0" name="type" value="0" checked>تصویر
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_type_1" name="type" value="1">صوت
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_type_2" name="type" value="2">ویدئو
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row" id="form_group_picture">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">آپلود فایل</label>
        <div class="col-lg-6 col-sm-12 col-md-5">
            <div class="card bg-light mb-3" style="">
                <div class="card-header">{!! $itmeFile['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_picture" role="alert">
                        انتخاب تصویر با فرمت های png و jpeg
                    </div>
                    {!! $itmeFile['modal_content'] !!}
                    <div id="show_area_medium_item_file"></div>
               </div>
            </div>
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_video">
        <label class="col-lg-2 col-md-3 col-sm-12 control-label col-form-label label_post" for="description">آپلود فایل</label>
        <div class="col-lg-10 col-md-9 col-sm-12 card-deck card_flex_item">
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding" style="">
                <div class="card-header">{!! $itmeVideoMp4File['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_video_mp4" role="alert">
                        انتخاب فایل ویدئویی با فرمت MP4 مناسب برای نمایش دادن در همه مرورگرها
                    </div>
                    {!! $itmeVideoMp4File['modal_content'] !!}
                    <div id="show_area_medium_video_mp4_file"></div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeVideoWebmFile['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_video_webm" role="alert">
                        انتخاب فایل ویدئویی با فرمت webm
                    </div>
                    {!! $itmeVideoWebmFile['modal_content'] !!}
                    <div id="show_area_medium_video_webm_file"></div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding" style="">
                <div class="card-header">{!! $itmeVideoOggFile['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_video_ogg" role="alert">
                        انتخاب فایل ویدئویی با فرمت ogg
                    </div>
                    {!! $itmeVideoOggFile['modal_content'] !!}
                    <div id="show_area_medium_video_ogg_file"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_audio">
        <label class="col-lg-2 col-md-3 col-sm-12 control-label col-form-label label_post" for="description">آپلود فایل</label>
        <div class="col-lg-10 col-md-9 col-sm-12 card-deck card_flex_item">
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeAudioOggFile['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_audio_ogg" role="alert">
                        انتخاب فایل صوتی با فرمت ogg
                    </div>
                    {!! $itmeAudioOggFile['modal_content'] !!}
                    <div id="show_area_medium_audio_ogg_file"></div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeAudioMp3File['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_audio_mp3" role="alert">
                        انتخاب فایل صوتی با فرمت mp3
                    </div>
                    {!! $itmeAudioMp3File['modal_content'] !!}
                    <div id="show_area_medium_audio_mp3_file"></div>
                </div>
            </div>
            <div class="card bg-light col-lg-4 col-md-6 col-sm-12 mb-3 no-padding">
                <div class="card-header">{!! $itmeAudioWavFile['button'] !!}</div>
                <div class="card-body">
                    <div class="alert alert-warning" id="warning_audio_wav" role="alert">
                        انتخاب فایل صوتی با فرمت ogg
                    </div>
                    {!! $itmeAudioWavFile['modal_content'] !!}
                    <div id="show_area_medium_audio_wav_file"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2 "><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary cancel_add_close_btn color_white"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>

</form>
<script>
    $(document).ready(function () {
        $('#gallery_item_description').summernote({
            height: 200,
        } );
        //--------------------------------------------tag select----------------------------------------------
        init_select2_ajax('#showSelectTagItem', '{{route('LTS.autoCompleteTag')}}', true,true);
        //------------------------------------------select 2 for language-----------------------------------------------------------------------------
        init_select2_data('#FaqSelectLangItme',{!! $multiLang !!});
    });

</script>