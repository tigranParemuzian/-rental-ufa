$(function () {

    $('.contact-form').validator();

    $('.contact-form').on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            var url = "vendor/contact/contact.php";

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable">' + messageText + '</div>';
                    if (messageAlert && messageText) {
                        $('.contact-form').find('.messages').html(alertBox);
                        $('.contact-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
});