<script>
    var frm_recovery_email = document.querySelector("#frm_recovery_email");
    var recovery_email_constraints = {
        email: {
            presence: {message: '^<strong>وارد کردن ایمیل الزامی است.</strong>'},
            email: {message: '^<strong>ایمیل وارد شده معتبر نمی باشد.</strong>'}
        },
    };
    init_validatejs(frm_recovery_email,recovery_email_constraints, ajax_func_recovery_email,"#frm_recovery_email");
    function ajax_func_recovery_email(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LUM.Recovery.storeRecoveryEmail')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_recovery_email .total_loader').remove();
                if (data.success) {
                    $('#form_message_box').addClass('hidden');
                    $('.show_success_message').removeClass('hidden').html(data.message);
                    // document.location = data.href
                }
                else {
                    $('.show_success_message').addClass('hidden');
                    showErrors(formElement, data.errors);
                }
            }
        });
    }
</script>