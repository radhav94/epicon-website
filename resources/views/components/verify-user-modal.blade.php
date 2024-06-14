<div class="modal fade" id="verifyotpmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="verifyotpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content">
            <div class="modal-body">
                <div class="childpin text-center py-4">

                    <form method="POST" id="verifyUserOtp" autocomplete="off">
                        <h5 class="mb-3">{{__('Enter the OTP sent to')}}</h5>
                        <p class="small mb-4" id="userdata">
                        </p>
                        <div class="childpin-input">
                            <input class="vpin onlydigit" type="text" min="0" max="9" maxlength="1"
                                name="vpin[]" required inputmode="numeric" pattern="[0-9]*">
                            <input class="vpin onlydigit" type="text" min="0" max="9" maxlength="1"
                                name="vpin[]" required inputmode="numeric" pattern="[0-9]*">
                            <input class="vpin onlydigit" type="text" min="0" max="9" maxlength="1"
                                name="vpin[]" required inputmode="numeric" pattern="[0-9]*">
                            <input class="vpin onlydigit" type="text" min="0" max="9" maxlength="1"
                                name="vpin[]" required inputmode="numeric" pattern="[0-9]*">
                            <input class="vpin onlydigit" type="text" min="0" max="9" maxlength="1"
                                name="vpin[]" required inputmode="numeric" pattern="[0-9]*">
                            <input class="vpin onlydigit" type="text" min="0" max="9" maxlength="1"
                                name="vpin[]" required inputmode="numeric" pattern="[0-9]*">

                        </div>
                        <div id="err_message" style="color: red;"> </div>
                        <button class="login-btn mt-4" style="width: 280px;" id="veryfy_submit">
                            {{__('Verify OTP')}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z"
                                    fill="#070707" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z"
                                    fill="#070707" />
                            </svg>
                        </button>
                        {{--<button class="login-btn mt-0 bg-transparent text-white btn-close"
                            data-bs-dismiss="modal" aria-label="Close" style="width: 280px;" type="button"
                            id="pinCloseBtn">{{__('Cancel')}}</button>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
