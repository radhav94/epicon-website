
function sendAjaxRequest(url, method, data, successCallback, errorCallback, contentType = false) {

    $.ajax({
        type: method,
        url: url,
        data: data,
        contentType: contentType,
        cache: false,
        processData: false,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            successCallback(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            errorCallback(xhr);
        },
        complete: function () {

        }
    });

    return false;

    /*
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);

    xhr.setRequestHeader('Content-Type', false);
    // xhr.setRequestHeader('Content-Type', 'application/json');

    // xhr.setRequestHeader('Content-Type', 'multipart/form-data');
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (successCallback) {
                    var responseData = JSON.parse(xhr.responseText);
                    successCallback(responseData);
                }
            } else {
                if (errorCallback) {
                    errorCallback(xhr.status);
                }
            }
        }
    };
    console.log(data);
    xhr.send(data);
    */
}

// Example usage
function onSuccess(responseData) {
    console.log('Success:', responseData);
}

function onError(statusCode) {
    console.log('Error:', statusCode);
}

$(document).on('click', '.emptyText', function () {
    $(this).parents('.input-field').find('input.form-control').val('');
});

