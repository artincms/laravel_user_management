<script>
    var frm_recovery_password = document.querySelector("#frm_recovery_password");
    var recovery_password_constraints = {
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
    init_validatejs(frm_recovery_password,recovery_password_constraints, ajax_func_recovery_password,"#frm_recovery_password");
    function ajax_func_recovery_password(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Recovery.storeRecoveryPassword')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_recovery_password .total_loader').remove();
                if (data.success) {
                    $('#form_message_box').addClass('hidden');
                    $('.show_success_message').removeClass('hidden').html(data.message);
                    document.location = data.href
                }
                else {
                    $('.show_success_message').addClass('hidden');
                    showErrors(formElement, data.errors);
                    var html='<div class="alert alert-danger"><ul>'
                    $.each(data.errors.error, function( k, v ) {
                        html += '<li>'+v+'</li>'  ;
                    });
                    html += '</ul></div>' ;
                    $('#form_message_box').html(html);
                }
            }
        });
    }
</script>