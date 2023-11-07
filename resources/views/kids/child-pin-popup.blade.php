<!-- Child Pin model -->
<div class="modal fade" id="child-pin-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered px-3">
        <div class="modal-content">
            <button class="x-btn bg-transparent text-white closebtn position-absolute" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z" fill="#F8F8F8" />
                </svg>
            </button>

            <div class="modal-body">
                {{--<h4 class="pb-4 border-bot">{{__('Create a 4-digit Child PIN')}}</h4>--}}

                <div class="childpin text-start pt-4">
                    <form id="childPinForm">
                        <div class="text-center">
                            <p class="small mb-4">{{__('This PIN will be used to switch from kids profile to all adult profiles')}}</p>
                            <div class="childpin-input pt-3">
                                <input class="mx-1 child-box onlydigit backpress" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="text" min="0" max="9" name="kidsPin[]" maxlength="1">
                            </div>
                            <button type="button" class="login-btn mt-5 ms-0" id="verifyChildPin">
                                Done
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="error-msg" class="text-center text-danger pt-2"></div>
                        <div id="success-msg" class="text-center text-success pt-2"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var queryParams = new URLSearchParams(window.location.search);
    $(document).ready(function() {
        $("#verifyChildPin").click(function() {
            $("#childPinForm #error-msg").html("");
            var formData = $('#childPinForm').serialize();
            $.ajax({
                url: "{{ route('verify-kidsPin') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    if (response.payload.success == true) {
                        if(queryParams.get('ref') == "subscription"){
                            window.location.href = APP_URL+'/subscription';
                            return false;
                        }else{
                            window.location.href = response.payload.redirect;
                            return false;
                        }
                    } else {
                        $("#childPinForm #error-msg").html(response.payload.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('error me aaya');
                    onError(xhr);
                }
            });
        })
    })
</script>