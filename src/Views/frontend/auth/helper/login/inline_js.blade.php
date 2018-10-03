<script>
    var frm_login_users = document.querySelector("#frm_user_login");
    var login_users_constraints = {
        username: {
            presence: {message: '^<strong>نام کاربری ضروری است.</strong>'},
            checkUsername: {message: '^<strong>کدملی وارد شده معتبر نمی باشد.</strong>'},
        },
        password: {
            presence: {message: '^<strong>وارد کردن رمزعبور الزامی است.</strong>'},
            length: {minimum: 6, message: '^<strong>کلمه عبور نمی‌تواند کمتر از 6 کاراکتر باشد.</strong>'}

        },
    };
    init_validatejs(frm_login_users, login_users_constraints, ajax_func_login_users,"#frm_user_login");
    function ajax_func_login_users(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Login.addLogin')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_user_login .total_loader').remove();
                if (data.success) {
                    $('#form_message_box').addClass('hidden');
                    $('.show_activation_message').removeClass('hidden').html('حساب کاربری شما ساخته شد . لطفا برای فعال سازی حساب کاربری از طریق ایمیل اقدام نمایید .');
                }
                else {
                    $('.show_activation_message').addClass('hidden');
                    showErrors(formElement, data.errors);
                }
            }
        });
    }
</script>