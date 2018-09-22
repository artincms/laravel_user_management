<script>
    //get gallery
    window['users_grid_columns'] = [
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
            width: '10%',
            data: 'username',
            name: 'username',
            title: 'نام کاربری',
        },
        {
            width: '10%',
            data: 'name',
            name: 'name',
            title: 'نام',
        },
        {
            width: '10%',
            data: 'last_name',
            name: 'last_name',
            title: 'نام خانوادگی',
        },
        {
            width: '15%',
            data: 'email',
            name: 'email',
            title: 'ایمیل',
        },
        {
            width: '15%',
            data: 'mobile',
            name: 'mobile',
            title: 'شماره همراه',
        },
        {
            width: '5%',
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.is_active))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="change_user_status_'+full.id+'" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_user(this)"' + ch + '>'
            }
        },
        {
            width: '5%',
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
            width: '5%',
            data: 'main_id',
            name: 'id',
            title: 'آی دی',
        },
        {
            width: '10%',
            data: 'created_at',
            name: 'created_at',
            title: 'تاریخ ثبت نام',
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
                    '   <a class="show_gallery_item pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-eye"></i><span class="ml-2">مشاهده آیتم ها</span>' +
                    '   </a>' +
                    '   <a class="btn_edit_gallery pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_gallery pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
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

        //-------------------------------------------------------submit filter data ------------------------------------------------
        $(document).off("click", ".btn_edit_user");
        $(document).on("click", ".btn_edit_user", function () {
            var $this = $(this);
            var user_id = $this.data('id');
            get_user_data(user_id);
        });

        function get_user_data(user_id) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{!!  route('LUM.Users.getEditUserForm') !!}',
                data: {user_id: user_id},
            success: function (result) {
                if (result.success) {
                    $('#edit_tab').html(result.html);
                    $('#tab_pill_edit').show();
                    $('#tab_pill_edit a').click();
                    $('#tab_link_edit').html('ویرایش اطلاعات ' + result.data.first_name + ' ' + result.data.last_name + ' (' + result.data.username + ')');
                }
            }
        });
        }
    })

    function change_status_user(input) {
        var $this = $(input);
        var user_id = $this.data('item_id');
        var checked = input.checked ;
        var item_id = input.id ;
        var parameters = {user_id: user_id, status: checked,item_id:item_id};
        yesNoAlert('تغییر وضعیت کاربر', 'از تغییر وضعیت کاربر مطمئن هستید ؟', 'warning', 'بله، وضعیت کاربر را تغییر بده!', 'لغو', set_user_status, parameters,remove_checked,parameters);
    }

    function set_user_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.setUserStatus') !!}',
            data: params,
            success: function (result) {
            if (result.success) {
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: result.title,
                    text : result.message ,
                    showConfirmButton: true,
                })
            }
        }
    });
    }

    function remove_checked (params) {
        var $this =$('#'+params.item_id) ;
        if(params.status)
        {
            $this.prop('checked', false);
        }
        else
        {
            $this.prop('checked', true);
        }
    }
    /*-------------------------------------------------------------------------------------------------------------*/
    function change_status_email(input) {
        var $this = $(input);
        var user_id = $this.data('item_id');
        var checked = input.checked ;
        var item_id = input.id ;
        var parameters = {user_id: user_id, status: checked,item_id:item_id};
        yesNoAlert(' تغییر وضعیت', 'از تغییر وضعیت تایید ایمیل مطمئن هستید ؟', 'warning', 'بله، وضعیت ایمیل  را تغییر بده!', 'لغو', set_email_status, parameters,remove_checked,parameters);
    }
    function set_email_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LUM.Users.setEmailStatus') !!}',
            data: params,
            success: function (result) {
            if (result.success) {
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: result.title,
                    text : result.message ,
                    showConfirmButton: true,
                })
            }
        }
    });
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


</script>