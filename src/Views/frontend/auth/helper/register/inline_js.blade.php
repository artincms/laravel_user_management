<script>
    var frm_register_users = document.querySelector("#frm_user_register");
    var register_users_constraints = {
        username: {
            presence: {message: '^<strong>نام کاربری ضروری است.</strong>'},
            checkUsername: {message: '^<strong>کدملی وارد شده معتبر نمی باشد.</strong>'},
        },

        email: {
            presence: {message: '^<strong>وارد کردن ایمیل الزامی است.</strong>'},
            email: {message: '^<strong>ایمیل وارد شده معتبر نمی باشد.</strong>'}
        },
        //
        // rules: {
        //     presence: {message: '^<strong>تایید قوانین الزامی است .</strong>'},
        // },
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
    init_validatejs(frm_register_users, register_users_constraints, ajax_func_register_users,"#frm_user_register",true);
    function ajax_func_register_users(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.register.addRegister')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_user_register .total_loader').remove();
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