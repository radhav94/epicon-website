$(document).ready(function () {
    $('.emptyText').click(function () {
        $(this).parents('.input-field').find('input').val('');
    });

    $("#profileAdd").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            dob: {
                required: true,
                date: true
            },
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.parent(".input-field"));
        },
        submitHandler: function (form) {

            sendAjaxRequest($(form).attr('action'), 'POST', new FormData(form),
                onSuccess, onError);

        }
    });

    $('#delete_profile').click(function () {
        if (confirm("Are you sure you want to proceed with the action?")) {
            sendAjaxRequest($(this).data('url'), 'POST', [],
                onSuccess, onError);
        }
    });


    $('#imgupload').on('change', function (event) {
        const imageInput = event.target;
        const imagePreview = $('#add-propik');

        // Check if a file was selected
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                var element = document.getElementById('add-propik');
                element.style.backgroundImage = "url(" + e.target.result + ")";

            };

            reader.readAsDataURL(imageInput.files[0]);
        } else {
            // Hide the image preview if no file was selected
            // imagePreview.attr('src', '').hide();
        }
    });

    $("#setPinForn").validate({
        rules: {
            // cpin_1: { required: true },
            // cpin_2: { required: true },
            // cpin_3: { required: true },
            // cpin_4: { required: true },
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.parent(".input-field"));
        },
        submitHandler: function (form) {
            let onSuccessPin = function (response) {
                showToaster(response?.message, 1);
                $('#pinCloseBtn').trigger('click');
            }
            sendAjaxRequest($(form).attr('action'), 'POST', new FormData(form), onSuccessPin, onError);
        }
    });

    //focus otp input
    $("#setPinForn .childpin-input .cpin").on("input", function () {
        const maxLength = parseInt($(this).attr("maxlength"));
        const currentLength = $(this).val().length;

        // If the current input field is filled, move to the next field
        if (currentLength === maxLength) {
            $(this).next(".cpin").val('');
            $(this).next(".cpin").focus();
        }
    });

});