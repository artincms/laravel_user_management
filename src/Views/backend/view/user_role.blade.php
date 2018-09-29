<div class="space-20"></div>
<div class="card">
    <div class="card-header">
        <div class="title_user_to_roles col-md-6 float-left" style="font-size: 18px;font-weight: bold;">
            <span><i class="far {{$class}} show_user_role_checkbox" id="fa_role_user" data-status="{{$status}}"></i></span>
            <span class="span_title_role_user"> انتصاب نقش به</span>
            @if(isset($user->name))
               <span> {{$user->name}} </span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <form class="form-horizontal" name="frm_set_permission_to_role" id="frm_set_permission_to_role" >
            <input type="hidden" name="user_id" id="set_user_id" value="{{$item_id}}">
            <div class="show_permissions">
                <ul class="ul_show_role_user">
                    @foreach($roles as $role)
                        <li>
                            <label class="checkbox-inline"><input class="check_role_user @if(in_array($role->id,$permission_ids)) selected_role @endif" data-item_id="{{$role->id}}" @if(in_array($role->id,$permission_ids)) checked @endif type="checkbox" value="" onchange="change_checked_role_user(this)"><span class="span_show_label_user_to_role">{{$role->display_name}}</span></label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="clearfixed"></div>
            <div class="space-20"></div>
            <div class="col-12">
                <button type="submit" class="float-right btn btn-success ml-2" id="submit_role_to_user"><i class="fa fa-save margin_left_8"></i>انتصاب</button>
                <button type="button" class="float-right btn bg-secondary color_white cancel_set_role_to_user_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
            </div>
        </form>
    </div>
</div>

<script>
    var role_count = {{count($roles)}} ;
    var user_role_count = {{count($permission_ids)}} ;
    $(document).off("click", "#submit_role_to_user");
    $(document).on("click", "#submit_role_to_user", function (e) {
        e.preventDefault() ;
        var user_id = $('#set_user_id').val();
        var items = [] ;
        $('.selected_role').each(function () {
          var id = $(this).data('item_id');
            items.push(id);
        }) ;

        $.ajax({
                type: "POST",
                url: '{{ route('LUM.Users.addRoleToUsers')}}',
                dataType: "json",
                data: {
                    item_id: user_id,
                    items: items,
                },
                success: function (data) {
                    if(data.success)
                    {
                        menotify('success', data.title, data.message);
                        $('.set_user_to_role_tab').addClass('hidden');
                        $('a[href="#manage_tab"]').click();
                    }
                    else
                    {
                        showMessages(data.message, 'form_message_box', 'error', formElement);
                        showErrors(formElement, data.errors);
                    }

                }
            })
    });

    $(document).off("click", ".cancel_set_role_to_user_btn");
    $(document).on("click", ".cancel_set_role_to_user_btn", function () {
        $('.set_user_to_role_tab').addClass('hidden');
        $('#show_form_roles_to_user').html('');
        $('a[href="#manage_tab"]').click();
    });

    $(document).off("click", ".show_user_role_checkbox");
    $(document).on("click", ".show_user_role_checkbox", function () {
        var status = $(this).attr('data-status');
        set_all_child_role_user_box(status,this);
    });

    function set_all_child_role_user_box(status,item) {
        if(status == 0)
        {
            $(item).removeClass('fa-circle');
            $(item).removeClass('fa-dot-circle');
            $(item).addClass('fa-check-circle');
            $(item).attr('data-status',2);
            user_role_count = role_count ;
            $('.check_role_user').each(function () {
                $(this).addClass('selected_role');
                $(this).prop('checked', true);
            });
        }
        else if(status == 1)
        {
            $(item).removeClass('fa-circle');
            $(item).removeClass('fa-check-circle');
            $(item).removeClass('fa-dot-circle');
            $(item).addClass('fa-check-circle');
            $(item).attr('data-status',2);
            user_role_count = role_count ;
            $('.check_role_user').each(function () {
                $(this).addClass('selected_role');
                $(this).prop('checked', true);
            });
        }
        else if(status == 2)
        {
            $(item).removeClass('fa-dot-circle');
            $(item).removeClass('fa-check-circle');
            $(item).addClass('fa-circle');
            $(item).attr('data-status',0);
            user_role_count = 0 ;
            $('.check_role_user').each(function () {
                $(this).removeClass('selected_role');
                $(this).prop('checked', false);
            }) ;
        }
    }

    function change_checked_role_user (input) {
        console.log(role_count,user_role_count);
        var checked = input.checked ;console.log(checked);
        var $this = $(input);
        if(checked)
        {
            $this.addClass('selected_role');
            user_role_count ++ ;
        }
        else
        {
            $this.removeClass('selected_role');
            user_role_count --;
        }
        $('#fa_role_user').removeClass('fa-circle');
        $('#fa_role_user').removeClass('fa-dot-circle');
        $('#fa_role_user').removeClass('fa-check-circle');
        if(user_role_count == role_count)
        {
            $('#fa_role_user').addClass('fa-check-circle');
        }
        else if(user_role_count>0)
        {
            $('#fa_role_user').addClass('fa-dot-circle');
        }
        else
        {
            $('#fa_role_user').addClass('fa-circle');
        }

    }

</script>