<div class="tab-pane text-white fade" id="v-pills-childpin" role="tabpanel" aria-labelledby="v-pills-childpin-tab">
    <div class="language-setting">
        <h4 class="pb-4 border-bot">{{__('Control kids’ access')}}</h4>

        <div class="childpin text-start py-4">
            <form id="childPinForm">
                <?php if (!$kidSection) { ?>
                    <div>
                        <input type="hidden" name="command" value="createKidsPin">
                        <h6 class="mb-3">{{__('Create a 4-digit Child PIN')}}</h6>
                        <p class="small mb-4">{{__('This PIN will be used to switch from kids profile to all adult profiles')}}</p>
                        <div class="childpin-input pt-3">
                            <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="kidsPin[]" maxlength="1">
                            <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="kidsPin[]" maxlength="1">
                            <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="kidsPin[]" maxlength="1">
                            <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="kidsPin[]" maxlength="1">
                        </div>
                        <button type="button" class="login-btn mt-5 ms-0" id="setChildPin" style="width: 280px;">
                            Done
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                            </svg>
                        </button>
                    </div>
                <?php } else { ?>
                    <div>
                        <input type="hidden" name="command" value="changeKidsPin">
                        <h6 class="mb-3">{{__('Change Child PIN')}}</h6>
                        <div class="d-flex align-items-center mb-4">
                            <p class="small" style="width: 150px;">{{__('Current PIN')}}</p>
                            <div class="childpin-input">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="oldKidsPin[]" maxlength="1">
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="small" style="width: 150px;">{{__('New PIN')}}</p>
                            <div class="childpin-input">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="newKidsPin[]" maxlength="1">
                                <input class="mx-1 child-box onlydigit backpress" type="password" min="0" max="9" name="newKidsPin[]" maxlength="1">
                            </div>
                        </div>
                        <button type="button" class="login-btn mt-5 ms-0" id="setChildPin" style="width: 280px;">
                            {{__('Done')}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                            </svg>
                        </button>
                    </div>
                <?php } ?>
                <div id="error-msg" style="color: red;"></div>
                <div id="success-msg" style="color: green;"></div>
            </form>
        </div>

    </div>
</div>