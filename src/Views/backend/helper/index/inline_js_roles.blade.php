<script type="text/javascript">
    window['roles_grid_columns'] = [
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
                return '<input class="styled " id="change_item_is_active_' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_role(this)"' + ch + '>'
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
                    '<div class="gallerty_menu float-right" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '   <a class="btn_set_permissions_to_role pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">افزودن دسترسی ها</span>' +
                    '   </a>' +
                    '   <a class="btn_edit_roles pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_roles pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                    '   </a>'
                    '  </div>' +
                    '</div>';
            }
        }
    ];
    $(document).ready(function () {
        var getRolesRoute = '{{ route('LUM.Roles.getRoles') }}';
        dataTablesGrid('#RolesGridData', 'RolesGridData', getRolesRoute, roles_grid_columns);
        var frm__add_roles = document.querySelector("#frm_create_roles");
        var create_roles_constraints = {
            name: {
                presence: {message: '^<strong>نام ضروری است.</strong>'}
            },
            display_name: {
                presence: {message: '^<strong>نام نمایشی ضروری است.</strong>'}
            },
        };
        init_validatejs(frm__add_roles, create_roles_constraints, ajax_func_add_roles);
        function ajax_func_add_roles(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('LUM.Roles.addRoles')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                $('#frm_create_roles .total_loader').remove();
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    clear_form_elements('#frm_create_roles');
                    menotify('success', data.title, data.message);
                    RolesGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_role"]').click();
                }
            }
            });
        }
        $(document).off("click", ".cancel_add_roles_btn");
        $(document).on("click", ".cancel_add_roles_btn", function () {
            $('a[href="#manage_tab_role"]').click();
        });
    });

    //--------------------------------active item ---------------------------------------------------//
    function change_is_active_role(input) {
        var checked = input.checked;
        var id = input.id;
        var item_id = $(input).data('item_id');
        var parameters = {is_active: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت تقش', 'از تغییر وضعیت تقش مطمئن هستید ؟', 'warning', 'بله، وضعیت تقش را تغییر بده!', 'لغو', set_roles_is_active, parameters, remove_checked_roles, parameters);
    }

    function set_roles_is_active(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Roles.changeRoleStauts') !!}',
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
    function remove_checked_roles(params) {
        var $this = $('#change_item_is_active_' + params.item_id);
        if (params.is_active) {
            $this.prop('checked', false);
        }
        else {
            $this.prop('checked', true);
        }
    }

    //-------------------------------------------------Edit roles-------------------------------------------------------//
    $(document).off("click", ".btn_edit_roles");
    $(document).on("click", ".btn_edit_roles ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_role_tab').html('ویرایش آیتم: ' + title);
        get_edit_rolse_form(item_id);
    });

    function get_edit_rolse_form(item_id) {
        $('#edit_role').children().remove();
        $('#edit_role').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Roles.getEditRolesForm')}}',
            dataType: "json",
            data: {
            item_id: item_id
        },
        success: function (result) {
            $('#edit_role .total_loader').remove();
            console.log(result);
            if (result.success) {
                $('#edit_role').append(result.get_edit_item);
                $('.edit_role_tab').removeClass('hidden');
                $('a[href="#edit_role"]').click();

                var edit_role_form_id = document.querySelector("#frm_edit_roles");
                var edit_roles_constraints = {
                    name: {
                        presence: {message: '^<strong>نام ضروری است.</strong>'}
                    },
                    display_name: {
                        presence: {message: '^<strong>نام نمایشی ضروری است.</strong>'}
                    },
                };
                init_validatejs(edit_role_form_id, edit_roles_constraints, ajax_func_edit_role);
                function ajax_func_edit_role(formElement) {
                    var formData = new FormData(formElement);
                    $.ajax({
                        type: "POST",
                        url: '{{ route('LUM.Roles.editRoles')}}',
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                        $('#frm_create_roles .total_loader').remove();
                        if (!data.success) {
                            showMessages(data.message, 'form_message_box', 'error', formElement);
                            showErrors(formElement, data.errors);
                        }
                        else {
                            clear_form_elements('#frm_create_roles');
                            menotify('success', data.title, data.message);
                            $('.edit_role_tab').addClass('hidden');
                            RolesGridData.ajax.reload(null, false);
                            $('a[href="#manage_tab_role"]').click();
                        }
                    }
                });
                }

                $(document).off("click", ".cancel_edit_roles_btn");
                $(document).on("click", ".cancel_edit_roles_btn", function () {
                    $('a[href="#manage_tab_role"]').click();
                    $('.edit_role_tab').addClass('hidden');
                    $('#edit_role').html('');
                });
            }
            else {

                }
            }
        });
    }

    /*___________________________________________________Trash Role_____________________________________________________________________*/
    $(document).off("click", ".btn_trash_roles");
    $(document).on("click", ".btn_trash_roles", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله تقش( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف تقش', 'از حذف تقش مطمئن هستید ؟', 'warning', desc, 'لغو', trash_role, parameters);
    });

    function trash_role(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Roles.trashRoles') !!}',
            data: params,
            success: function (data) {
            if (!data.success) {
                showMessages(data.message, 'form_message_box', 'error', formElement);
                showErrors(formElement, data.errors);
            }
            else {
                menotify('success', data.title, data.message);
                RolesGridData.ajax.reload(null, false);
            }
        }
    });
    }



</script>