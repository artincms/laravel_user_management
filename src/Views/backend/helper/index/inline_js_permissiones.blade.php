<script type="text/javascript">
    window['permissions_grid_columns'] = [
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
            width: '5%',
            data: 'id',
            name: 'id',
            title: 'آی دی',
            visible:false
        },
        {
            width: '20%',
            data: 'name',
            name: 'name',
            title: 'نام',
        },
        {
            width: '20%',
            data: 'display_name',
            name: 'display_name',
            title: 'نام نمایشی',
        },
        {
            width: '25%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
        },
        {
            width: '10%',
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.is_active))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="change_item_is_active_' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_permission(this)"' + ch + '>'
            }
        },
        {
            width: '10%',
            data: 'created_at',
            name: 'created_at',
            title: 'تاریخ ایجاد',
        },
        {
            width: '10%',
            searchable: false,
            sortable: false,
            title: 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<div class="gallerty_menu float-right pointer" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '   <a class="btn_edit_permissions pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_permissions pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                    '   </a>'
                    '  </div>' +
                    '</div>';
            }
        }
    ];
    window['permissions_category_grid_columns'] = [
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
            width: '5%',
            data: 'id',
            name: 'id',
            title: 'آی دی',
            visible:false
        },
        {
            width: '20%',
            data: 'title',
            name: 'title',
            title: 'نام',
        },
        {
            width: '25%',
            data: 'parent_id',
            name: 'parent_id',
            title: 'گالری والد',
            mRender: function (data, type, full) {
                if (full.parent != null)
                    return full.parent.title;
                else
                    return '';
            }
        },
        {
            width: '25%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
        },
        {
            width: '10%',
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.is_active))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="change_permission_category_is_active_' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_permission_category(this)"' + ch + '>'
            }
        },
        {
            width: '10%',
            data: 'created_at',
            name: 'created_at',
            title: 'تاریخ ایجاد',
        },
        {
            width: '10%',
            searchable: false,
            sortable: false,
            title: 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<div class="gallerty_menu float-right pointer" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '   <a class="btn_add_permission pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fas fa-reply"></i><span class="ml-2">افزودن دسترسی</span>' +
                    '   </a>' +
                    '   <a class="btn_edit_permission_categorys pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_permission_categorys pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                    '   </a>'
                    '  </div>' +
                    '</div>';
            }
        }
    ];
    $(document).ready(function () {
        var getPermissionCategorysRoute = '{{ route('LUM.Permissions.getPermissionCategorys') }}';
        dataTablesGrid('#PermissionCategorysGridData', 'PermissionCategorysGridData', getPermissionCategorysRoute, permissions_category_grid_columns);
        var frm__add_permission_categorys = document.querySelector("#frm_create_permission_categorys");
        var create_permission_categorys_constraints = {
            title: {
                presence: {message: '^<strong>نام ضروری است.</strong>'}
            },
        };
        init_select2_ajax('#permission_category_parrent', '{{route('LUM.Permissions.autoCompletePermissionCategory')}}',true);
        init_validatejs(frm__add_permission_categorys, create_permission_categorys_constraints, ajax_func_add_permission_categorys);
        function ajax_func_add_permission_categorys(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('LUM.Permissions.addPermissionCategorys')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                $('#frm_create_permission_categorys .total_loader').remove();
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    clear_form_elements('#frm_create_permission_categorys');
                    menotify('success', data.title, data.message);
                    PermissionCategorysGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_permission_category"]').click();
                }
            }
        });
        }
        $(document).off("click", ".cancel_add_permission_categorys_btn");
        $(document).on("click", ".cancel_add_permission_categorys_btn", function () {
            $('a[href="#manage_tab_permission_category"]').click();
        });
    });

    //--------------------------------active item ---------------------------------------------------//
        function change_is_active_permission_category(input) {
            var checked = input.checked;
            var id = input.id;
            var item_id = $(input).data('item_id');
            var parameters = {is_active: checked, item_id: item_id};
            yesNoAlert('تغییر وضعیت دسته بندی', 'از تغییر وضعیت دسته بندی مطمئن هستید ؟', 'warning', 'بله، وضعیت دسته بندی را تغییر بده!', 'لغو', set_permission_categorys_is_active, parameters, remove_checked_permission_categorys, parameters);
        }

        function set_permission_categorys_is_active(params) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{!!  route('LUM.Permissions.changePermissionCategoryStauts') !!}',
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
        function remove_checked_permission_categorys(params) {
            var $this = $('#change_permission_category_is_active_' + params.item_id);
            if (params.is_active) {
                $this.prop('checked', false);
            }
            else {
                $this.prop('checked', true);
            }
        }

    //--------------------------------------- permession ------------------------------------------------------//
    $(document).off("click", ".btn_add_permission");
    $(document).on("click", ".btn_add_permission ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.permissin_manager_tab').removeClass('hidden')
        $('.span_permissin_manager_tab').html('افزودن دسترسی به : ' + title);
        $('a[href="#permissin_manager"]').click();
            var getPermissionsRoute = '{{ route('LUM.Permissions.getPermissions') }}';
            $('#hidden_permission_category_id').val(item_id) ;
            data_permission={
                item_id:item_id
            };
            dataTablesGrid('#PermissionsGridData', 'PermissionsGridData', getPermissionsRoute, permissions_grid_columns,data_permission);
        //--------------------------------active item ---------------------------------------------------//
        function change_is_active_permission(input) {
            var checked = input.checked;
            var id = input.id;
            var item_id = $(input).data('item_id');
            var parameters = {is_active: checked, item_id: item_id};
            yesNoAlert('تغییر وضعیت دسترسی', 'از تغییر وضعیت دسترسی مطمئن هستید ؟', 'warning', 'بله، وضعیت دسترسی را تغییر بده!', 'لغو', set_permissions_is_active, parameters, remove_checked_permissions, parameters);
        }

        function set_permissions_is_active(params) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{!!  route('LUM.Permissions.changePermissionStauts') !!}',
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
        function remove_checked_permissions(params) {
            var $this = $('#change_item_is_active_' + params.item_id);
            if (params.is_active) {
                $this.prop('checked', false);
            }
            else {
                $this.prop('checked', true);
            }
        }

        //-------------------------------------------------Edit permissions-------------------------------------------------------//
        $(document).off("click", ".btn_edit_permissions");
        $(document).on("click", ".btn_edit_permissions ", function () {
            var item_id = $(this).data('item_id');
            var title = $(this).data('title');
            $('.span_edit_permission_tab').html('ویرایش آیتم: ' + title);
            get_edit_permissions_form(item_id);
        });

        function get_edit_permissions_form(item_id) {
            $('#edit_permission').children().remove();
            $('#edit_permission').append(generate_loader_html('لطفا منتظر بمانید...'));
            $.ajax({
                type: "POST",
                url: '{{ route('LUM.Permissions.getEditPermissionsForm')}}',
                dataType: "json",
                data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_permission .total_loader').remove();
                if (result.success) {
                    $('#edit_permission').append(result.get_edit_item);
                    $('.edit_permission_tab').removeClass('hidden');
                    $('a[href="#edit_permission"]').click();

                    var edit_permission_form_id = document.querySelector("#frm_edit_permissions");
                    var edit_permissions_constraints = {
                        name: {
                            presence: {message: '^<strong>نام ضروری است.</strong>'}
                        },
                        display_name: {
                            presence: {message: '^<strong>نام نمایشی ضروری است.</strong>'}
                        },
                    };
                    init_validatejs(edit_permission_form_id, edit_permissions_constraints, ajax_func_edit_permission);
                    function ajax_func_edit_permission(formElement) {
                        var formData = new FormData(formElement);
                        $.ajax({
                            type: "POST",
                            url: '{{ route('LUM.Permissions.editPermissions')}}',
                            dataType: "json",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                            $('#frm_edit_permissions .total_loader').remove();
                            if (!data.success) {
                                showMessages(data.message, 'form_message_box', 'error', formElement);
                                showErrors(formElement, data.errors);
                            }
                            else {
                                clear_form_elements('#frm_create_permissions');
                                menotify('success', data.title, data.message);
                                $('.edit_permission_tab').addClass('hidden');
                                PermissionsGridData.ajax.reload(null, false);
                                $('a[href="#manage_tab_permission"]').click();
                            }
                        }
                    });
                    }
                    $(document).off("click", ".cancel_edit_permissions_btn");
                    $(document).on("click", ".cancel_edit_permissions_btn", function () {
                        $('a[href="#manage_tab_permission"]').click();
                        $('.edit_permission_tab').addClass('hidden');
                        $('#edit_permission').html('');
                    });
                }
                else {

                }
            }
        });
        }

        /*___________________________________________________Trash Permission_____________________________________________________________________*/
        $(document).off("click", ".btn_trash_permissions");
        $(document).on("click", ".btn_trash_permissions", function () {
            var item_id = $(this).data('item_id');
            var title = $(this).data('title');
            desc = 'بله دسترسی( ' + title + ' ) را حذف کن !';
            var parameters = {item_id: item_id};
            yesNoAlert('حذف دسترسی', 'از حذف دسترسی مطمئن هستید ؟', 'warning', desc, 'لغو', trash_permission, parameters);
        });

        function trash_permission(params) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{!!  route('LUM.Permissions.trashPermissions') !!}',
                data: params,
                success: function (data) {
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    PermissionsGridData.ajax.reload(null, false);
                }
            }
        });
        }
    });

    //---------------------------------------edit permession category ------------------------------------------------------//

    $(document).off("click", ".btn_edit_permission_categorys");
    $(document).on("click", ".btn_edit_permission_categorys ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_permissin_manager_tab').html('ویرایش آیتم: ' + title);
        get_edit_permission_category_form(item_id);
    });

    function get_edit_permission_category_form(item_id) {
        $('#edit_permission_category').children().remove();
        $('#edit_permission_category').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Permissions.getEditPermissionCategorysForm')}}',
            dataType: "json",
            data: {
            item_id: item_id
        },
        success: function (result) {
            $('#edit_permission_category .total_loader').remove();
            if (result.success) {
                $('#edit_permission_category').append(result.get_edit_item);
                $('.edit_permission_category_tab').removeClass('hidden');
                $('a[href="#edit_permission_category"]').click();

                var edit_permission_category_form_id = document.querySelector("#frm_edit_permission_categorys");
                var edit_permission_categorys_constraints = {
                    title: {
                        presence: {message: '^<strong>نام ضروری است.</strong>'}
                    },
                };
                init_validatejs(edit_permission_category_form_id, edit_permission_categorys_constraints, ajax_func_edit_permission_category);
                function ajax_func_edit_permission_category(formElement) {
                    var formData = new FormData(formElement);
                    $.ajax({
                        type: "POST",
                        url: '{{ route('LUM.Permissions.editPermissionCategorys')}}',
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                        $('#frm_create_permission_categorys .total_loader').remove();
                        if (!data.success) {
                            showMessages(data.message, 'form_message_box', 'error', formElement);
                            showErrors(formElement, data.errors);
                        }
                        else {
                            clear_form_elements('#frm_create_permission_categorys');
                            menotify('success', data.title, data.message);
                            $('.edit_permission_category_tab').addClass('hidden');
                            PermissionCategorysGridData.ajax.reload(null, false);
                            $('a[href="#manage_tab_permission_category"]').click();
                        }
                    }
                });
                }

                $(document).off("click", ".cancel_edit_permission_categorys_btn");
                $(document).on("click", ".cancel_edit_permission_categorys_btn", function () {
                    $('a[href="#manage_tab_permission_category"]').click();
                    $('.edit_permission_category_tab').addClass('hidden');
                    $('#edit_permission_category').html('');
                });
            }
            else {

            }
        }
    });
    }

    /*___________________________________________________Trash Permission Category_____________________________________________________________________*/
    $(document).off("click", ".btn_trash_permission_categorys");
    $(document).on("click", ".btn_trash_permission_categorys", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله دسته بندی( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف دسته بندی', 'از حذف دسته بندی مطمئن هستید ؟', 'warning', desc, 'لغو', trash_permission_category, parameters);
    });

    function trash_permission_category(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Permissions.trashPermissionCategorys') !!}',
            data: params,
            success: function (data) {
            if (!data.success) {
                showMessages(data.message, 'form_message_box', 'error', formElement);
                showErrors(formElement, data.errors);
            }
            else {
                menotify('success', data.title, data.message);
                PermissionCategorysGridData.ajax.reload(null, false);
            }
        }
    });
    }

    //-----------------------------------
    $(document).off("click", ".cancel_add_permission_btn");
    $(document).on("click", ".cancel_add_permission_btn", function () {
        $('a[href="#manage_tab_permission_category"]').click();
        $('.permissin_manager_tab').addClass('hidden');
    });

    //---------------------------------------------------Add permissions-----------------------------------------------------//
    var frm__add_permissions = document.querySelector("#frm_create_permissions");
    var create_permissions_constraints = {
        name: {
            presence: {message: '^<strong>نام ضروری است.</strong>'}
        },
        display_name: {
            presence: {message: '^<strong>نام نمایشی ضروری است.</strong>'}
        },
    };
    init_validatejs(frm__add_permissions, create_permissions_constraints, ajax_func_add_permissions);
    function ajax_func_add_permissions(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Permissions.addPermissions')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_create_permissions .total_loader').remove();
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    clear_form_elements('#frm_create_permissions');
                    menotify('success', data.title, data.message);
                    PermissionsGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_permission"]').click();
                }
            }
        });
    }
    $(document).off("click", ".cancel_add_permissions_btn");
    $(document).on("click", ".cancel_add_permissions_btn", function () {
        $('a[href="#manage_tab_permission"]').click();
    });
</script>