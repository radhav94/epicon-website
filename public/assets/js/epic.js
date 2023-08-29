
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

const showToaster = (message, type = 1, timeout = 5000) => {
    if (type == 1) {
        toastr.success(message, "Success", {
            timeOut: timeout
        });
    } else {
        toastr.error(message, "Error", {
            timeOut: timeout
        });
    }
};

$(document).on('click', '.emptyText', function () {
    $(this).parents('.input-field').find('input.form-control').val('');
});



// start add to wishlist
$(document).on('click', '.addToList', function () {
    let action = $(this).data('action');
    let id = $(this).data('id');

    let element = $(this);

    let requestData = {
        content_id: id,
        action: action,
    };

    sendAjaxRequest(APP_URL + '/wishlist', 'POST', JSON.stringify(requestData),
        onWishlistSuccess, onWishlistError, 'application/json');

    function onWishlistSuccess(response) {
        element.data('action', element.data('action') === 'add' ? 'delete' : 'add');
        element.toggleClass('add-icon delete-icon');

        showToaster(response?.message, 1);
    }

    function onWishlistError(response) {
        showToaster('Some error occured', 2);
    }
});
// end start add to wishlist