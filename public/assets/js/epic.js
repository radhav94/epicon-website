
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
function onSuccess(response) {
    showToaster(response?.message, 1);

    if (response.payload?.redirect != undefined) {
        setTimeout(() => {
            window.location.href = response.payload?.redirect;
        }, 1000);
    }
    console.log('Success:', response);
}

function onError(xhr) {
    $msg = 'Some Error occured';
    try {
        $res = JSON.parse(xhr.responseText);
        if ($res.message != undefined) {
            $msg = $res.message;
        }
    } catch (err) { }
    showToaster($msg, 2);
    console.log('Error:', xhr);
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
    let type = $(this).data('type');

    let element = $(this);

    let requestData = {
        content_id: id,
        action: action,
        type: type,
    };

    sendAjaxRequest(APP_URL + '/wishlist', 'POST', JSON.stringify(requestData),
        onWishlistSuccess, onError, 'application/json');

    function onWishlistSuccess(response) {
        console.log('type : ' + type);
        if (type == 1) {
            console.log(response.payload?.icon);
            element.replaceWith(response.payload?.icon);
        } else if (type == 3) {
            element.data('action', element.data('action') === 'add' ? 'delete' : 'add');

            if (action == 'add') {
                element.find('.wl_add').hide();
                element.find('.wl_remove').show();
            } else {
                element.find('.wl_add').show();
                element.find('.wl_remove').hide();
            }

        } else {
            element.data('action', element.data('action') === 'add' ? 'delete' : 'add');
            element.toggleClass('add-icon delete-icon');
        }


        showToaster(response?.message, 1);
    }
});
// end start add to wishlist

$(document).on('keydown', '.onlydigit', function (e) {
    if (e.key.match(/[^0-9]/) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
        e.preventDefault();
    }
});

//social share
$(document).on('click', '.shareThis', function () {
    let url = $(this).data('url');
    let title = $(this).data('title') || 'Epic On';

    console.log(title);

    $('#shareDiv').empty();
    $('#shareDiv').socialSharingPlugin({
        url: url,
        title: title,
        description: title,
        // description: $('meta[property="og:description"]').attr('content'),
        // img: $('meta[property="og:image"]').attr('content'),
        enable: ['copy', 'facebook', 'twitter']
    });
    $('#shareModal').modal('show')
});
//end social share

$('.menu-close').click(function (e) {
    e.preventDefault();
});