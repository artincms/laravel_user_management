<script>
    window['gallery_item_columns'] = [
        {
            width: '5%',
            data: 'id',
            title: 'ردیف',
            searchable: false,
            sortable: false,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: 'id',
            name: 'id',
            title: 'آی دی',
            visible: false
        },
        {
            width: '12%',
            data: 'order',
            name: 'order',
            title: 'ترتیب',
            searchable: false,
            mRender: function (data, type, full) {
                var order = GalleryItemGridData.order();
                if (order[0][0] == 2) {
                    if (order[0][1] == 'desc') {
                        var result = '';
                        result += '' +
                            '<div class="input-group mb-3">' +
                            '   <div class="input-group-prepend ">' +
                            '       <button type="button" style="float: right;border-radius: 0px;" class="btn btn-outline-secondary reorder_gallery_item_form_grid_data bg-info-400" ' +
                            '           data-order_type="increase" ' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-gallery_id="' + full.gallery_id + '" >' +
                            '           <i class="fas fa-level-up-alt"></i>'  +
                            '       </button>' +
                            '   </div>' +
                            '   <input type="text" class="form-control text-center" style="width:30% " disabled value="'+full.order+'">' +
                            '    <div class="input-group-append">' +
                            '       <button type="button" style="border-radius: 0px;" class="btn btn-outline-secondary reorder_gallery_item_form_grid_data bg-info-800" ' +
                            '           data-order_type="decrease"' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-gallery_id="' + full.gallery_id + '" >' +
                            '       <i class="fas fa-level-down-alt fa-flip-horizontal"></i>' +
                            '   </button>';
                        '   </div>' +
                        '</div>';
                        return result;
                    }
                    else {
                        var result = ''+
                            '<div class="input-group mb-3">' +
                            '   <div class="input-group-prepend ">' +
                            '       <button type="button" style="float: right;border-radius: 0px;" class="btn btn-outline-secondary reorder_gallery_item_form_grid_data bg-info-400" ' +
                            '           data-order_type="decrease" ' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-gallery_id="' + full.gallery_id + '">' +
                            '           <i class="fas fa-level-up-alt"></i>'  +
                            '       </button>' +
                            '   </div>' +
                            '   <input type="text" class="form-control text-center" style="width:30% " disabled value="'+full.order+'">' +
                            '    <div class="input-group-append">' +
                            '       <button type="button" style="border-radius: 0px;" class="btn btn-outline-secondary reorder_gallery_item_form_grid_data bg-info-800" ' +
                            '           data-order_type="increase"' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-gallery_id="' + full.gallery_id + '">' +
                            '       <i class="fas fa-level-down-alt fa-flip-horizontal"></i>' +
                            '   </button>';
                        '   </div>' +
                        '</div>';
                        return result;
                    }
                }
                else {
                    return '<span class="order_number">' + full.order + '</span>';
                }
            }
        },
        {
            data: 'type',
            name: 'type',
            title: 'نوع',
            mRender: function (data, type, full) {
                if (full.type == 0) {
                    return 'تصویر' ;

                } else if (full.type == 1) {
                    return 'صوت' ;
                } else {
                    return 'ویدئو' ;
                }
            }
        },
        {
            width: '20%',
            data: 'title',
            name: 'title',
            title: 'عنوان',
        },
        {
            width: '25%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
            mRender: function (data, type, full) {
                if(full.description)
                {
                    return '<div class="text_over_flow pointer td_description" onclick="hide_text_over_flow(this)">'+full.description+'</div>'
                }
                else
                {
                    return '' ;
                }
            }
        },
        {
            width: '25%',
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.is_active))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="change_item_is_active_' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_item(this)"' + ch + '>'
            }
        },
        {
            width: '20%',
            searchable: false,
            sortable: false,
            title: 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                        '<div class="gallerty_menu float-right" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                        '<span>' +
                        '   <em class="fas fa-caret-down"></em>' +
                        '   <i class="fas fa-bars"></i> ' +
                        '</span>' +
                        '  <div class="dropdown_gallery hidden">' +
                        '   <a class="btn_edit_gallery_item pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                        '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                        '   </a>' +
                        '    <a class="btn_trash_gallery_item pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
                        '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                        '   </a>'
                    '  </div>' +
                    '</div>';
            }
        }
    ];
    var create_gallery_item_constraints = {
        title: {
            presence: {message: '^<strong>عنوان فرم ضروری است.</strong>'}
        },
        order: {
            numericality: {
                onlyInteger: true,
                message: '^<strong>ترتیب نامعتبر است .</strong>'
            }
        }
    };
    $(document).off("click", ".show_gallery_item");
    $(document).on("click", ".show_gallery_item", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('a[href="#manage_tab_item"]').click();
        $('.manage_gallery_item_tab').removeClass('hidden');
        var html = '' +
            '<div class="space-20"></div>' +
            '<table id="GalleryItemGridData" class="table" width="100%"></table>';
        $('.span_manage_gallery_item_tab').html('آیتم : ' + title);
        $('#manage_tab_gallery_item').html(html);
        datatable_load_item(item_id);
        $(document).off("click", "#add_gallery_item_tab");
        $(document).on("click", "#add_gallery_item_tab", function () {
            get_gallery_item(item_id);
        });

        function get_gallery_item(item_id) {
            $('#add_gallery_picture').append(generate_loader_html('لطفا منتظر بمانید...'));
            $.ajax({
                type: "POST",
                url: '{{ route('LGS.getAddGalleryItemForm')}}',
                dataType: "json",
                data: {
                    item_id: item_id
                },
                success: function (result) {
                    $('#edit_gallery .total_loader').remove();
                    if (result.status == true) {
                        $('#add_gallery_item').html(result.gallery_add_item);
                        var frm_gallery_add_item = document.querySelector("#frm_create_gallery_item");
                        init_validatejs(frm_gallery_add_item, create_gallery_item_constraints, ajax_func_add_gallery_item);

                        function ajax_func_add_gallery_item(formElement) {
                            var formData = new FormData(formElement);
                            $.ajax({
                                type: "POST",
                                url: '{{ route('LGS.createGalleryItem')}}',
                                dataType: "json",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    $('#frm_create_gallery_item .total_loader').remove();
                                    if (data.status == -1) {
                                        showMessages(data.message, 'form_message_box', 'error', formElement);
                                        showErrors(formElement, data.errors);
                                    }
                                    else {
                                        clear_form_elements('#frm_create_gallery_item');
                                        menotify('success', data.title, data.message);
                                        GalleryItemGridData.ajax.reload(null, false);
                                        $('a[href="#manage_tab_gallery_item"]').click();
                                        $('#show_area_medium_item_file').html('');
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }
        //--------------filter------------------------------------------------------------------
        $(document).off('change', '.filter_item_is_active');
        $(document).on('change', '.filter_item_is_active', datatable_reload_item_fun);
        init_doAfterStopTyping('.filter_item_title', datatable_reload_item_fun);
        function datatable_reload_item_fun() {
            var filter_item_is_active = $('.filter_item_is_active').val();
            var filter_item_title = $('.filter_item_title').val();
            GalleryItemGridData.destroy();
            $('#GalleryItemGridData').empty();
            datatable_load_item(item_id, filter_item_is_active,filter_item_title);
        }
    });

    /*___________________________________________________close manage_____________________________________________________________________*/
    $(document).off("click", ".cancel_manage_gallery_item");
    $(document).on("click", ".cancel_manage_gallery_item", function () {
        $('a[href="#manage_tab"]').click();
        $('.manage_gallery_item_tab').addClass('hidden');
        //$('#edit_gallery').html('');
    });

    /*___________________________________________________change is_active_____________________________________________________________________*/
    function change_is_active_item(input) {
        console.log();
        var checked = input.checked;
        var id = input.id;
        var item_id = $(input).data('item_id');
        var parameters = {is_active: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت گالری', 'از تغییر وضعیت گالری مطمئن هستید ؟', 'warning', 'بله، وضعیت گالری را تغییر بده!', 'لغو', set_item_is_active, parameters, remove_checked_item, parameters);
    }

    function set_item_is_active(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.setItemStatus') !!}',
            data: params,
            success: function (result) {
                if (result.success) {
                    menotify('success', result.title, result.message);
                }
                else {

                }
            }
        });
    }

    function remove_checked_item(params) {
        var $this = $('#change_item_is_active_' + params.item_id);
        if (params.is_active) {
            $this.prop('checked', false);
        }
        else {
            $this.prop('checked', true);
        }
    }

    /*___________________________________________________add item_____________________________________________________________________*/

    function showitemFile(res) {
        $('#show_area_medium_item_file').html(res.itemFile.view.medium);
        $('#warning_picture').addClass('hidden');
    }

    function showVideoMp4File(res) {
        $('#show_area_medium_video_mp4_file').html(res.videoMp4itemFile.view.medium);
        $('#warning_video_mp4').addClass('hidden');
    }

    function showVideoWebmFile(res) {
        $('#show_area_medium_video_webm_file').html(res.videoWebmFile.view.medium);
        $('#warning_video_webm').addClass('hidden');
    }

    function showVideoOggFile(res) {
        $('#show_area_medium_video_ogg_file').html(res.videoOggFile.view.medium);
        $('#warning_video_ogg').addClass('hidden');
    }

    function showAudioOggFile(res) {
        $('#show_area_medium_audio_ogg_file').html(res.audioOggFile.view.medium);
        $('#warning_audio_ogg').addClass('hidden');
    }

    function showAudioMp3File(res) {
        $('#show_area_medium_audio_mp3_file').html(res.audioMp3File.view.medium);
        $('#warning_audio_mp3').addClass('hidden');
    }

    function showAudioWavFile(res) {
        $('#show_area_medium_audio_wav_file').html(res.audioWavFile.view.medium);
        $('#warning_audio_wav').addClass('hidden');
    }

    /*___________________________________________________Edit Gallery Item_____________________________________________________________________*/
    $(document).off("click", ".btn_edit_gallery_item ");
    $(document).on("click", ".btn_edit_gallery_item ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_gallery_item_tab').html('ویرایش آیتم: ' + title);
        get_edit_gallery_item_form(item_id);
    });

    function get_edit_gallery_item_form(item_id) {
        $('#edit_gallery_item').children().remove();
        $('#edit_gallery_item').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.getEditGalleryItemForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_gallery_item .total_loader').remove();
                if (result.status == true) {
                    $('#edit_gallery_item').append(result.gallery_item_edit_view);
                    $('.edit_gallery_item_tab').removeClass('hidden');
                    $('a[href="#edit_gallery_item"]').click();

                    var edit_gallery_item_form_id = document.querySelector("#frm_edit_gallery_item");
                    init_validatejs(edit_gallery_item_form_id, create_gallery_item_constraints, ajax_func_edit_gallery_item);
                }
                else {

                }
            }
        });
    }

    function ajax_func_edit_gallery_item(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.editGalleryItem')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_edit_gallery .total_loader').remove();
                if (data.status == -1) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    GalleryItemGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_gallery_item"]').click();
                    $('.edit_gallery_item_tab').addClass('hidden');
                    $('#edit_gallery_item').html('');
                }
            }
        });
    }

    /*___________________________________________________cancel edit gallery item button_____________________________________________________________________*/
    $(document).off("click", ".cancel_edit_gallery_item_tab");
    $(document).on("click", ".cancel_edit_gallery_item_tab", function () {
        $('a[href="#manage_tab_gallery_item"]').click();
        $('.edit_gallery_item_tab').addClass('hidden');
        $('#edit_gallery_item').html('');
    });

    /*___________________________________________________Trash Gallery Item_____________________________________________________________________*/
    $(document).off("click", ".btn_trash_gallery_item");
    $(document).on("click", ".btn_trash_gallery_item", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله گالری( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف گالری', 'از حذف گالری مطمئن هستید ؟', 'warning', desc, 'لغو', trash_gallery_item, parameters);
    });

    function trash_gallery_item(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.trashGalleryItem') !!}',
            data: params,
            success: function (data) {
                if (data.status == -1) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    GalleryItemGridData.ajax.reload(null, false);
                }
            }
        });
    }

    /*___________________________________________________change type_____________________________________________________________________*/
    $(document).off("change", 'input[type=radio][name=type]');
    $(document).on("change", 'input[type=radio][name=type]', function () {
        show_input_file(this.value);
    });

    function show_input_file(value) {
        if (value == 2) {
            $('#form_group_video').removeClass('hidden');
            $('#form_group_picture').addClass('hidden');
            $('#form_group_audio').addClass('hidden');
        }
        else if (value == 1) {
            $('#form_group_video').addClass('hidden');
            $('#form_group_picture').addClass('hidden');
            $('#form_group_audio').removeClass('hidden');
        }
        else {
            $('#form_group_video').addClass('hidden');
            $('#form_group_picture').removeClass('hidden');
            $('#form_group_audio').addClass('hidden');
        }
    }

    $(window).click(function(e) {
        if(!$(e.target).closest(".td_description").length >0)
        {
            $('.td_description').addClass('text_over_flow dd');
        }
    });
    function hide_text_over_flow(el)
    {
       $(el).toggleClass('text_over_flow')
    }
    /*___________________________________________________DataTable_____________________________________________________________________*/

    function datatable_load_item(item_id,filter_item_is_active,filter_item_title) {
        item_id = item_id || false;
        filter_item_is_active = filter_item_is_active || false;
        filter_item_title = filter_item_title || '';
        var fixedColumn = {
            leftColumns: 2,
            rightColumns: 2
        };
        data =
            {
                filter_item_is_active: filter_item_is_active,
                filter_item_title: filter_item_title,
                item_id: item_id,
            };
        dataTablesGrid('#GalleryItemGridData', 'GalleryItemGridData', '{{ route('LGS.getGalleryItem') }}', gallery_item_columns, data);
        $('#GalleryItemGridData thead').append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_item_title" name="filter_item_title" value="' + filter_item_title + '" style="width: 100%;">' +
            '   </td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_item_is_active" name="filter_item_is_active" style="width:150px">' +
            '           <option value="-1">انتخاب وضعیت</option>' +
            '           <option value="0" '+('0' === filter_item_is_active ? 'selected="selected"' : '')+'>غیرفعال</option>' +
            '           <option value="1" '+('1' === filter_item_is_active ? 'selected="selected"' : '')+'>فعال</option>' +
            '       </select>' +
            '    </td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '</tr>'
        );
    }

    /*-----------------------------------------------Order item------------------------------------------------------*/
    $(document).off("click", '.reorder_gallery_item_form_grid_data');
    $(document).on('click', '.reorder_gallery_item_form_grid_data', function () {
        var $this = $(this);
        var order_type = $this.data('order_type');
        var item_id = $this.data('item_id');
        var gallery_id = $this.data('gallery_id');
        reOrderGalleryItemFormGridData(order_type, item_id,gallery_id);
    });

    function reOrderGalleryItemFormGridData(order_type, item_id,gallery_id) {
        var result = false;
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.saveOrderGalleryItemForm')}}',
            dataType: "json",
            data: {item_id:item_id, order_type: order_type,gallery_id:gallery_id},
            success: function (data) {
                if (data.success == true) {
                    window.GalleryItemGridData.ajax.reload(null,false);
                    result = true;
                }
            }
        });
        return result;
    }

</script>