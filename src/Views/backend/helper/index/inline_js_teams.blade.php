<script type="text/javascript">
    window['teams_grid_columns'] = [
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
                return '<input class="styled " id="change_team_is_active_' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_team(this)"' + ch + '>'
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
                    '   <a class="btn_set_permissions_to_team pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + '">' +
                    '       <i class="fa fa-reply"></i><span class="ml-2">افزودن دسترسی ها</span>' +
                    '   </a>' +
                    '   <a class="btn_edit_teams pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_teams pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.name + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                    '   </a>'
                    '  </div>' +
                    '</div>';
            }
        }
    ];
    $(document).ready(function () {
        var getteamsRoute = '{{ route('LUM.Teams.getTeams') }}';
        dataTablesGrid('#teamsGridData', 'teamsGridData', getteamsRoute, teams_grid_columns);
        var frm__add_teams = document.querySelector("#frm_create_teams");
        var create_teams_constraints = {
            name: {
                presence: {message: '^<strong>نام ضروری است.</strong>'}
            },
            display_name: {
                presence: {message: '^<strong>نام نمایشی ضروری است.</strong>'}
            },
        };
        init_validatejs(frm__add_teams, create_teams_constraints, ajax_func_add_teams);
        function ajax_func_add_teams(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('LUM.Teams.addTeams')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                $('#frm_create_teams .total_loader').remove();
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    clear_form_elements('#frm_create_teams');
                    menotify('success', data.title, data.message);
                    teamsGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_team"]').click();
                }
            }
            });
        }
        $(document).off("click", ".cancel_add_teams_btn");
        $(document).on("click", ".cancel_add_teams_btn", function () {
            $('a[href="#manage_tab_team"]').click();
        });
    });

    //--------------------------------active item ---------------------------------------------------//
    function change_is_active_team(input) {
        var checked = input.checked;
        var id = input.id;
        var item_id = $(input).data('item_id');
        var parameters = {is_active: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت تیم', 'از تغییر وضعیت تیم مطمئن هستید ؟', 'warning', 'بله، وضعیت تیم را تغییر بده!', 'لغو', set_teams_is_active, parameters, remove_checked_teams, parameters);
    }

    function set_teams_is_active(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Teams.changeTeamStauts') !!}',
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
    function remove_checked_teams(params) {
        var $this = $('#change_team_is_active_' + params.item_id);
        if (params.is_active) {
            $this.prop('checked', false);
        }
        else {
            $this.prop('checked', true);
        }
    }

    //-------------------------------------------------Edit teams-------------------------------------------------------//
    $(document).off("click", ".btn_edit_teams");
    $(document).on("click", ".btn_edit_teams ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_team_tab').html('ویرایش آیتم: ' + title);
        get_edit_rolse_form(item_id);
    });

    function get_edit_rolse_form(item_id) {
        $('#edit_team').children().remove();
        $('#edit_team').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Teams.getEditTeamsForm')}}',
            dataType: "json",
            data: {
            item_id: item_id
        },
        success: function (result) {
            $('#edit_team .total_loader').remove();
            console.log(result);
            if (result.success) {
                $('#edit_team').append(result.get_edit_item);
                $('.edit_team_tab').removeClass('hidden');
                $('a[href="#edit_team"]').click();

                var edit_team_form_id = document.querySelector("#frm_edit_teams");
                var edit_teams_constraints = {
                    name: {
                        presence: {message: '^<strong>نام ضروری است.</strong>'}
                    },
                    display_name: {
                        presence: {message: '^<strong>نام نمایشی ضروری است.</strong>'}
                    },
                };
                init_validatejs(edit_team_form_id, edit_teams_constraints, ajax_func_edit_team);
                function ajax_func_edit_team(formElement) {
                    var formData = new FormData(formElement);
                    $.ajax({
                        type: "POST",
                        url: '{{ route('LUM.Teams.editTeams')}}',
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                        $('#frm_create_teams .total_loader').remove();
                        if (data.success) {
                            clear_form_elements('#frm_create_teams');
                            menotify('success', data.title, data.message);
                            $('.edit_team_tab').addClass('hidden');
                            teamsGridData.ajax.reload(null, false);
                            $('a[href="#manage_tab_team"]').click();
                        }
                        else {
                            showMessages(data.message, 'form_message_box', 'error', formElement);
                            showErrors(formElement, data.errors);
                        }
                    }
                });
                }

                $(document).off("click", ".cancel_edit_teams_btn");
                $(document).on("click", ".cancel_edit_teams_btn", function () {
                    $('a[href="#manage_tab_team"]').click();
                    $('.edit_team_tab').addClass('hidden');
                    $('#edit_team').html('');
                });
            }
            else {

                }
            }
        });
    }

    /*___________________________________________________Trash team_____________________________________________________________________*/
    $(document).off("click", ".btn_trash_teams");
    $(document).on("click", ".btn_trash_teams", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله تیم( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف تیم', 'از حذف تیم مطمئن هستید ؟', 'warning', desc, 'لغو', trash_team, parameters);
    });

    function trash_team(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Teams.trashTeams') !!}',
            data: params,
            success: function (data) {
            if (!data.success) {
                showMessages(data.message, 'form_message_box', 'error', formElement);
                showErrors(formElement, data.errors);
            }
            else {
                menotify('success', data.title, data.message);
                teamsGridData.ajax.reload(null, false);
            }
        }
    });
    }



</script>