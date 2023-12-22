<?php
$userId = getUserId();
?>
@extends('layouts.default')
@section('title', 'Max Device')

@section('content')
    <section class="w-100 mt-4 tb-margin-mobile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-9 pb-4 m-auto">
                    <div class="setting-right">

                        <div class="text-white">
                            <div class="language-setting">
                                <h4 class="pb-4 border-bot">{{ __('Manage the active devices') }}</h4>


                                <div class="container-fluid">
                                    <?php if (count($activeDevices) > 0) {
                                    $isOther = false;
                                    $otherDevice = '<div class="row pt-4">
                                        <div class="col-sm-4 col-md-3">
                                            <p>Other Devices</p>
                                        </div>
                                        <div class="col-sm-8 col-md-9" id="otherDevice">';

                                    foreach ($activeDevices as $device) {
                                        $deviceId = $device['id'];
                                        $deviceContent = '<div class="row" data-id="' . $deviceId . '">
                                                <div class="col-sm-6 col-md-7">
                                                    <div class="form-check d-flex align-items-center ps-0 mb-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M3.9375 2.25C3.29103 2.25 2.67105 2.50681 2.21393 2.96393C1.75681 3.42105 1.5 4.04103 1.5 4.6875V16.3125C1.5 16.959 1.75681 17.579 2.21393 18.0361C2.67105 18.4932 3.29103 18.75 3.9375 18.75H9.0075V20.2507H6.759C6.65856 20.2476 6.55851 20.2646 6.46479 20.3009C6.37106 20.3371 6.28558 20.3918 6.21341 20.4617C6.14124 20.5316 6.08385 20.6154 6.04467 20.7079C6.00548 20.8004 5.98529 20.8999 5.98529 21.0004C5.98529 21.1009 6.00548 21.2003 6.04467 21.2929C6.08385 21.3854 6.14124 21.4691 6.21341 21.539C6.28558 21.6089 6.37106 21.6637 6.46479 21.6999C6.55851 21.7361 6.65856 21.7532 6.759 21.75H17.253C17.3534 21.7532 17.4535 21.7361 17.5472 21.6999C17.6409 21.6637 17.7264 21.6089 17.7986 21.539C17.8708 21.4691 17.9281 21.3854 17.9673 21.2929C18.0065 21.2003 18.0267 21.1009 18.0267 21.0004C18.0267 20.8999 18.0065 20.8004 17.9673 20.7079C17.9281 20.6154 17.8708 20.5316 17.7986 20.4617C17.7264 20.3918 17.6409 20.3371 17.5472 20.3009C17.4535 20.2646 17.3534 20.2476 17.253 20.2507H15.0045V18.75H20.0625C20.709 18.75 21.329 18.4932 21.7861 18.0361C22.2432 17.579 22.5 16.959 22.5 16.3125V4.6875C22.5 4.04103 22.2432 3.42105 21.7861 2.96393C21.329 2.50681 20.709 2.25 20.0625 2.25H3.9375ZM13.5045 18.75V20.2507H10.5075V18.75H13.5045ZM3 4.6875C3 4.17 3.42 3.75 3.9375 3.75H20.0625C20.58 3.75 21 4.17 21 4.6875V16.3125C21 16.83 20.58 17.25 20.0625 17.25H3.9375C3.42 17.25 3 16.83 3 16.3125V4.6875Z" fill="white"></path>
                                                        </svg>
                                                        <div class="ms-3">
                                                            <p class="mb-0 w-auto">' . $device['device'] . '</p>
                                                            <span class="small text-opacity">' . __('Last Active') . ': ' . lastActiveTime($device['date']) . '</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-md-4">
                                                    <button class="border-btn mb-4" onclick="logoutDevice(' . $deviceId . ')">' . __('Log Out') . '</button>
                                                </div>
                                            </div>';

                                        if (getDeviceId() == $deviceId) {
                                            @$thisDevice = '<div class="row border-bot" data-id="' . $deviceId . '">
                                                <div class="col-sm-4 col-md-3">
                                                    <p>This Device</p>
                                                </div>

                                                <div class="col-sm-8 col-md-9">
                                                    ' . $deviceContent . '
                                                </div>
                                            </div>';
                                        } else {
                                            $isOther = true;
                                            $otherDevice .= $deviceContent;
                                        }
                                    }
                                    @$otherDevice .= '</div>
                                        </div>';
                                    echo @$thisDevice;
                                    echo $isOther ? $otherDevice : '';
                                } else { ?>
                                    <div class="row pt-4">
                                        <div class="col-sm-4 col-md-3">
                                            <p>{{ __('No device found') }}</p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@stop
@section('script')
    <script>
        var userId = "{{ $userId }}";
        var deviceId = "{{ getDeviceId() }}";

        $(document).ready(function() {
            showToaster('You can only log in a maximum of 5 devices at a time. Please log out of any extra devices below to continue on this device.', 2);
        });
        
        function logoutDevice(params) {
            if (params == "") return;
            var formData = {
                deviceId: params
            }
            $.ajax({
                url: "{{ route('remove-device') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        $("div[data-id='" + params + "']").remove();
                        showToaster('Device logout successfully.', 1);
                        if ($('#otherDevice').html() == '') {
                            $('#otherDevice').parent().remove();
                        }
                        if (deviceId == params) {
                            location.reload();
                        }
                    } else {
                        $("#updateInterestForm #error-meg-for-genre-select").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        }
    </script>
@stop
