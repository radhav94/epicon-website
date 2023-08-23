
function sendAjaxRequest(url, method, data, successCallback, errorCallback) {
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
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

    xhr.send(JSON.stringify(data));
}

// Example usage
function onSuccess(responseData) {
    console.log('Success:', responseData);
}

function onError(statusCode) {
    console.log('Error:', statusCode);
}

