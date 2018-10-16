<script>
    //get gallery
    window['users_grid_columns'] = [
        {
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
            visible:false
        },

        {
            width:'100px',
            data: 'username',
            name: 'username',
            title: 'نام کاربری',
        },
        {
            width:'100px',
            data: 'first_name',
            name: 'first_name',
            title: 'نام',
        },
        {
            width:'100px',
            data: 'last_name',
            name: 'last_name',
            title: 'نام خانوادگی',
        },
        {
            data: 'email',
            name: 'email',
            title: 'ایمیل',
        },
        {
            data: 'mobile',
            name: 'mobile',
            title: 'شماره همراه',
        },
        {
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.user_confirmed))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="change_user_status_'+full.id+'" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_user(this)"' + ch + '>'
            }
        },
        {
            width: '80px',
            data: 'email_confirmed',
            name: 'email_confirmed',
            title: 'تایید ایمیل',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.email_confirmed))
                    ch = 'checked';
                else
                    ch = '';
                return '<input id="change_email_status_'+full.id+'" class="styled" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_email(this)"' + ch + '>'
            }
        },
        {
            width: '50px',
            data: 'email_confirmed',
            name: 'email_confirmed',
            title: 'تایید موبایل',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.mobile_confirmed))
                    ch = 'checked';
                else
                    ch = '';
                return '<input id="change_mobile_status_'+full.id+'" class="styled" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_mobile(this)"' + ch + '>'
            }
        },
        // {
        //     width: '5%',
        //     data: 'main_id',
        //     name: 'id',
        //     title: 'آی دی',
        // },
        {
            data: 'created_at',
            name: 'created_at',
            title: 'تاریخ ثبت نام',
        },
        {
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
                    '   <a class="btn_role_to_user pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.username + '">' +
                    '       <i class="fa fa-reply"></i><span class="ml-2">افزودن نقش ها</span>' +
                    '   </a>' +
                    '   <a class="btn_permission_to_user pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.username + '">' +
                    '       <i class="fa fa-reply"></i><span class="ml-2">افزودن دسترسی ها</span>' +
                    '   </a>' +
                    '   <a class="btn_edit_user pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.username + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_user pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.username + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">حذف</span>' +
                    '   </a>'
                '  </div>' +
                '</div>';
            }
        }
    ];

    $(document).ready(function () {
        var getUsersRoute = '{{ route('LUM.Users.getUsers') }}';
        var fixedColumn =  {
            leftColumns: 3,
            rightColumns: 1
        };
        dataTablesGrid('#UsersGridData', 'UsersGridData', getUsersRoute, users_grid_columns, null, null, true, null, null, 1, 'desc',false,fixedColumn);
    });

    function change_status_user(input) {
        var $this = $(input);
        var item_id = $this.data('item_id');
        var checked = input.checked ;
        var parameters = {is_active: checked,item_id:item_id};
        yesNoAlert('تغییر وضعیت کاربر', 'از تغییر وضعیت کاربر مطمئن هستید ؟', 'warning', 'بله، وضعیت کاربر را تغییر بده!', 'لغو', set_user_status, parameters,remove_checked_user,parameters);
    }

    function set_user_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.setUserStatus') !!}',
            data: params,
            success: function (result) {
            if (result.success) {
                menotify('success', result.title, result.message);
            }
            else
            {
                Messages(data.message, 'form_message_box', 'error', formElement);
                showErrors(formElement, data.errors);
            }

        }
    });
    }

    function remove_checked_user (params) {
        var $this =$('#change_user_status_'+params.item_id) ;console.log($this);
        if(params.is_active)
        {
            $this.prop('checked', false);
        }
        else
        {
            $this.prop('checked', true);
        }
    }
    /*------------------------------------------------Change Email Status-------------------------------------------------------------*/
    function change_status_email(input) {
        var $this = $(input);
        var item_id = $this.data('item_id');
        var checked = input.checked ;
        var parameters = {is_active: checked,item_id:item_id};
        yesNoAlert(' تغییر وضعیت', 'از تغییر وضعیت تایید ایمیل مطمئن هستید ؟', 'warning', 'بله، وضعیت ایمیل  را تغییر بده!', 'لغو', set_email_status, parameters,remove_checked_email,parameters);
    }
    function set_email_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.setEmailStatus') !!}',
            data: params,
            success: function (result) {
                if (result.success) {
                    menotify('success', result.title, result.message);
                }
                else
                {
                    Messages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }

            }
        });
    }
    function remove_checked_email (params) {
        var $this =$('#change_email_status_'+params.item_id) ;console.log($this);
        if(params.is_active)
        {
            $this.prop('checked', false);
        }
        else
        {
            $this.prop('checked', true);
        }
    }

    /*------------------------------------------------Change mobile Status-------------------------------------------------------------*/
    function change_status_mobile(input) {
        var $this = $(input);
        var item_id = $this.data('item_id');
        var checked = input.checked ;
        var parameters = {is_active: checked,item_id:item_id};
        yesNoAlert(' تغییر وضعیت', 'از تغییر وضعیت تایید ایمیل مطمئن هستید ؟', 'warning', 'بله، وضعیت ایمیل  را تغییر بده!', 'لغو', set_mobile_status, parameters,remove_checked_mobile,parameters);
    }
    function set_mobile_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.setMobileStatus') !!}',
            data: params,
            success: function (result) {
                if (result.success) {
                    menotify('success', result.title, result.message);
                }
                else
                {
                    Messages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }

            }
        });
    }
    function remove_checked_mobile (params) {
        var $this =$('#change_mobile_status_'+params.item_id) ;console.log($this);
        if(params.is_active)
        {
            $this.prop('checked', false);
        }
        else
        {
            $this.prop('checked', true);
        }
    }
    /*-----------------------------------------------------------------------------*/
    $(document).off("click", ".btn_trash_user");
    $(document).on("click", ".btn_trash_user", function () {
        var $this = $(this);
        var user_id = $this.data('id');
        yesNoAlert('حذف کاربر', 'از حذف کاربر هستید؟', 'warning', 'بله، حذف شود!', 'لغو', trash_user, {user_id: user_id});
    });
    function trash_user(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.trashUser') !!}',
            data: {user_id: params.user_id},
        success: function (result) {
            if(result.success)
            {
                window['UsersGridData'].ajax.reload(null,false);
            }
        }
    });
    }

    /*___________________________________________________FixedColumn_____________________________________________________________________*/
    function set_fixed_dropdown_menu(e) {
        $(e).find('.dropdown_gallery').toggleClass('hidden');
        var position = $(e).offset();
        var position2 = $(e).position();
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        var drop_height = $(e).find('.dropdown_gallery').height() + 16;
        if (($(window).height() - position.top) > drop_height) {
            $(e).find('.dropdown_gallery').css({'position': 'fixed', 'top': position.top - scrollTop + 16, 'left': Math.abs(position.left) + 20, 'height': 'fit-content'});
            window.addEventListener("scroll", function (event) {
                var scroll = this.scrollY;
                $(e).find('.dropdown_gallery').css('top', position.top - scroll + 16)
            });
        }
        else {
            $(e).find('.dropdown_gallery').css({'position': 'fixed', 'top': position.top - scrollTop + 16 - drop_height, 'left': Math.abs(position.left) + 20, 'height': 'fit-content'});
            window.addEventListener("scroll", function (event) {
                var scroll = this.scrollY;
                $(e).find('.dropdown_gallery').css('top', position.top - scroll + 16 - drop_height)
            });
        }
    }
    $(window).click(function(e) {
        if (!$(e.target).closest(".gallerty_menu ").length > 0) {
            $('.dropdown_gallery').addClass('hidden');
        }
    });

    $(document).off("click", ".close_message_btn");
    $(document).on("click", ".close_message_btn", function () {
        console.log('dd');
       $('#form_message_box').html('');
    });

    //-----------------------------------set permissions---------------------------------------//
    $(document).off("click", ".btn_set_permissions_to_role");
    $(document).on("click", ".btn_set_permissions_to_role", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.title_permissino').html('انتصاب دسترسی به نقش: ' + title);
        var type = 2 ;
        $('#set_permission_id').val(item_id);
        $('#permission_type').val(type);

        set_permissions(item_id,type);
    });

    $(document).off("click", ".btn_permission_to_user");
    $(document).on("click", ".btn_permission_to_user", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.title_permissino').html('انتصاب دسترسی به کاربر: ' + title);
        var type = 1 ;
        set_permissions(item_id,type);
    });

    function set_permissions(item_id,type) {
        $('#show_form_permission_to_role').children().remove();
        $('#set_permissions').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Permissions.getRolePermissionForm')}}',
            dataType: "json",
            data: {
                item_id: item_id,
                type: type,
            },
            success: function (result) {
                $('#set_permissions .total_loader').remove();
                if(result.success)
                {
                    $('#show_form_permission_to_role').append(result.get_permission_role);
                    $('.set_permissions_tab_tab').removeClass('hidden');
                    $('a[href="#set_permissions"]').click();
                }
                else
                {

                }

            }
        })
    }

    $(document).off("click", '.show_permission_checkbox');
    $(document).on('click', '.show_permission_checkbox', function (e) {
        var item_id = $(this).data('item_id');
        var font_class = '#font_check_'+item_id ;
        var show_div_id = '#show_div_'+item_id ;
        var status = $(show_div_id).attr('data-status');
        console.log(status,item_id,show_div_id);
        if(status == 0)
        {
            $(font_class).removeClass('fa-circle');
            $(font_class).addClass('fa-check-circle');
            $(show_div_id).attr('data-status',2);
            set_all_child_box(item_id);
        }
        else if(status == 1)
        {
            $(font_class).removeClass('fa-circle');
            $(font_class).removeClass('fa-dot-circle');
            $(font_class).addClass('fa-check-circle');
            $(show_div_id).attr('data-status',2);
            set_all_child_box(item_id);
        }
        else if(status == 2)
        {
            $(font_class).removeClass('fa-check-circle');
            $(font_class).addClass('fa-circle');
            $(show_div_id).attr('data-status',0);
            set_none_child_box(item_id);
        }

    });

    function set_all_child_box(item_id) {
        var check_class = '.pch_'+item_id ;
        $(check_class).each(function () {
            $(this).addClass('selected');
            $(this).prop('checked', true);
        }) ;
        var font_class_i  = '.font_check_i_'+item_id ;
        $(font_class_i).each(function () {
            $(this).removeClass('fa-circle');
            $(this).removeClass('fa-dot-circle');
            $(this).addClass('fa-check-circle');
            $(this).prop('checked', true);
        }) ;

        var font_show_div  = '.show_div_'+item_id ;
        $(font_show_div).each(function () {
            $(this).attr('data-status', 2);
        }) ;
    }

    function set_none_child_box(item_id) {
        var check_class = '.pch_'+item_id ;
        $(check_class).each(function () {
            $(this).removeClass('selected');
            $(this).prop('checked', false);
        }) ;

        var font_class_i  = '.font_check_i_'+item_id ;
        $(font_class_i).each(function () {
            $(this).removeClass('fa-check-circle');
            $(this).addClass('fa-circle');
            $(this).prop('checked', true);
        }) ;
        var font_show_div  = '.show_div_'+item_id ;
        $(font_show_div).each(function () {
            $(this).attr('data-status', 0);
        }) ;
    }

    function change_checked(input) {
        var $this = $(input);
        $this.toggleClass('selected');
        var class_name = $this.attr('class');
        class_name = class_name.replace(' selected','');
        class_name = class_name.replace(' checkbox','');
        class_name = class_name.split(" ")
        var user_id = $this.data('item_id');
        var checked = input.checked ;
        $(class_name).each(function () {
            var item = this.replace('pch','#font_check');
            var div_item = this.replace('pch','#show_div');
            $(item).each(function () {
                $(this).removeClass('fa-check-circle');
                $(this).removeClass('fa-circle');
                $(this).addClass('fa-dot-circle');
            });
            $(div_item).each(function () {
                $(this).attr('data-status',1);
            });
        }) ;
        var selected
        $('.checkbox').each(function () {
            if($(this).hasClass('selected'))
            {
                return selected = true ;
            }
            else
            {
                return selected = false ;
            }
        });
        console.log(selected);
        if(!selected)
        {
        //     $('.show_permission_checkbox').each(function () {
        //         $('.far').removeClass('fa-dot-circle')
        //         $('.far').addClass('fa-check-circle')
        //     });
        }
    }

    $(document).off("click", ".btn_role_to_user");
    $(document).on("click", ".btn_role_to_user", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        set_roles_to_user(item_id);
    });

    function set_roles_to_user(item_id,type) {
        $('#show_form_roles_to_user').children().remove();
        $('#set_user_to_roles').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Roles.getUserRoleForm')}}',
            dataType: "json",
            data: {
                item_id: item_id,
                type: type,
            },
            success: function (result) {
                $('#set_user_to_roles .total_loader').remove();
                if(result.success)
                {
                    $('#show_form_roles_to_user').append(result.get_user_role);
                    $('.set_user_to_role_tab').removeClass('hidden');
                    $('a[href="#set_user_to_roles"]').click();
                }
                else
                {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }

            }
        })
    }

    $(document).off("click", ".cancel_add_users_btn");
    $(document).on("click", ".cancel_add_users_btn", function () {
        $('a[href="#manage_user"]').click();
    });

    //-----------------add user -------------------------------------------------------------//
    var frm__add_users = document.querySelector("#frm_create_users");
    var create_users_constraints = {
        username: {
            presence: {message: '^<strong>نام کاربری ضروری است.</strong>'},
            length: {minimum: 5, message: '^<strong>نام کاربری نمی‌تواند کمتر از 5 کاراکتر باشد.</strong>'},
            length: {maximum: 20, message: '^<strong>نام کاربری نمی‌تواند بیشتر از 20 کاراکتر باشد.</strong>'}
    },
        first_name: {
            presence: {message: '^<strong>نام ضروری است.</strong>'},
            length: {minimum: 2, message: '^<strong>نام  نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام نمی‌تواند بیشتر از 60 کاراکتر باشد.</strong>'}
        },
        last_name: {
            presence: {message: '^<strong>نام خانوادگی ضروری است.</strong>'},
            length: {minimum: 2, message: '^<strong>نام خانوادگی  نمی‌تواند کمتر از 2 کاراکتر باشد.</strong>'},
            length: {maximum: 60, message: '^<strong>نام خانوادگی نمی‌تواند بیشتر از 60 کاراکتر باشد.</strong>'}
        },
        email: {
            presence: {message: '^<strong>وارد کردن ایمیل الزامی است.</strong>'},
            email: {message: '^<strong>ایمیل وارد شده معتبر نمی باشد.</strong>'}
        },
        mobile: {
            // presence: {message: '^<strong>وارد کردن موبایل الزامی است.</strong>'},
            iranMobileNumber: {message: '^<strong>شماره همراه وارد شده صحیح نمی باشد.</strong>'},
            length: {maximum: 11, message: '^<strong>شماره همراه نمی‌تواند بیشتر از 11 کاراکتر باشد.</strong>'}
        },
        password: {
            presence: {message: '^<strong>وارد کردن رمزعبور الزامی است.</strong>'},
            length: {minimum: 6, message: '^<strong>کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.</strong>'}

        },
        password_confirmation: {
            presence: {message: '^<strong>وارد کردن تکرار کلمه عبور الزامی است.</strong>'},
            length: {minimum: 6, message: '^<strong>تکرار کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.</strong>'},
            equality: {
                attribute: "password",
                message: '^<strong>تکرار رمز عبور با رمز عبور وارد شده یکسان نیست.</strong>',
                comparator: function (v1, v2) {
                    return JSON.stringify(v1) === JSON.stringify(v2);
                }
            }
        },
    };
    init_validatejs(frm__add_users, create_users_constraints, ajax_func_add_users);
    function ajax_func_add_users(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Users.addUsers')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_create_users .total_loader').remove();
                if (data.success) {
                    $('.edit_user_tab').addClass('hidden');
                    $('#edit_user').html('');
                    menotify('success', data.title, data.message);
                    UsersGridData.ajax.reload(null, false);
                    $('a[href="#manage_user"]').click();

                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
    }
    //----------------------------------------------------edit user-----------------------------------------------------//
    $(document).off("click", ".btn_edit_user");
    $(document).on("click", ".btn_edit_user ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_user_tab').html('ویرایش آیتم: ' + title);
        get_edit_user_form(item_id);
    });

    function get_edit_user_form(item_id) {
        $('#edit_user').children().remove();
        $('#edit_user').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Users.getEditUserForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_user .total_loader').remove();
                if (result.success) {
                    $('#edit_user').append(result.get_edit_item);
                    $('.edit_user_tab').removeClass('hidden');
                    $('a[href="#edit_user"]').click();
                }
                else
                {
                    showMessages(result.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, result.errors);
                }
            }
        });
    }

    /*___________________________________________________Trash Users_____________________________________________________________________*/
    $(document).off("click", ".btn_trash_user");
    $(document).on("click", ".btn_trash_user", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله کاربر( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف کاربر', 'از حذف کاربر مطمئن هستید ؟', 'warning', desc, 'لغو', trash_user, parameters);
    });

    function trash_user(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.trashUser') !!}',
            data: params,
            success: function (data) {
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    UsersGridData.ajax.reload(null, false);
                }
            }
        });
    }
</script>