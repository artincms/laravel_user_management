<form class="form-horizontal" name="frm_set_permission_to_role" id="frm_set_permission_to_role" >
    <input type="hidden" name="set_permission_id" id="set_permission_id" value="{{$item_id}}">
    <input type="hidden" name="permission_type" id="permission_type" value="{{$type}}">
    <div class="show_permissions">
        <ul id="ul_show_permissions">
            {!! $permissions !!}
        </ul>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2" id="submit_role_permission"><i class="fa fa-save margin_left_8"></i>انتصاب</button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_set_permission_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>

<script>
    $(document).off("click", "#submit_role_permission");
    $(document).on("click", "#submit_role_permission", function (e) {
        e.preventDefault() ;
        var permission_id = $('#set_permission_id').val();
        var permission_type = $('#permission_type').val();
        var items = [] ;
        $('.selected').each(function () {
          var id = $(this).data('item_id');
            items.push(id);
        }) ;
        if(items.length > 0)
        {
            $.ajax({
                type: "POST",
                url: '{{ route('LUM.Permissions.addRoleToPermission')}}',
                dataType: "json",
                data: {
                    item_id: permission_id,
                    type: permission_type,
                    items: items,
                },
                success: function (data) {
                    if(data.success)
                    {
                        menotify('success', data.title, data.message);
                        $('.set_permissions_tab_tab').addClass('hidden');
                        if(permission_type == 2)
                        {
                            $('a[href="#roles_manager"]').click();
                        }
                        else
                        {
                            $('a[href="#manage_tab"]').click();
                        }
                    }
                    else
                    {
                        showMessages(data.message, 'form_message_box', 'error', formElement);
                        showErrors(formElement, data.errors);
                    }

                }
            })
        }
        else
        {
            alert('d');
        }
    });

    $(document).off("click", ".cancel_set_permission_btn");
    $(document).on("click", ".cancel_set_permission_btn", function () {
        $('.set_permissions_tab_tab').addClass('hidden');
        $('#show_form_permission_to_role').html('');
        var type = $('#permission_type').val();
        if(type == 2)
        {
            $('a[href="#roles_manager"]').click();
        }
        else
        {
            $('a[href="#manage_tab"]').click();
        }
    });
</script>