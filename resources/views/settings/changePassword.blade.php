<div class="tab-pane text-white fade" id="v-pills-changed-password" role="tabpanel" aria-labelledby="v-pills-changed-password-tab">
    <div class="language-setting">
        <h4 class="pb-4 border-bot">{{__('Manage your passwords')}}</h4>

        <div class="childpin text-start py-4">
            <form id="change_password">
                <h6 class="mb-3">{{__('Change Password')}}</h6>

                <div class="container-fluid ps-0">
                    <div class="row">
                        <div class="col-sm-3 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center">
                            <p>{{__('Current Password')}}</p>
                        </div>
                        <div class="col-sm-4 col-md-7 col-lg-6 col-xl-5">
                            <div class="input-field w-100 mb-3">
                                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="{{__('Current Password')}}">
                                <button class="eye" type="button" data-target="old_password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                        <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                    </svg>
                                </button>
                                <span class="text-danger text-start d-flex mt-1 cngPwd" id="oldPwd" style="font-size: 12px;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center">
                            <p>{{__('New Password')}}</p>
                        </div>
                        <div class="col-sm-4 col-md-7 col-lg-6 col-xl-5">
                            <div class="input-field w-100 mb-3">
                                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="{{__('New Password')}}">
                                <button type="button" class="eye" data-target="new_password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                        <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                    </svg>
                                </button>
                                <span class="text-danger text-start d-flex mt-1 cngPwd" id="newPwd" style="font-size: 12px;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center">
                            <p>{{__('Confirm Password')}}</p>
                        </div>
                        <div class="col-sm-4 col-md-7 col-lg-6 col-xl-5">
                            <div class="input-field w-100 mb-3">
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="{{__('Confirm Password')}}">
                                <button class="eye" type="button" data-target="confirm_password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16" viewBox="0 0 22 16" fill="none">
                                        <path d="M11 5C10.2044 5 9.44129 5.31607 8.87868 5.87868C8.31607 6.44129 8 7.20435 8 8C8 8.79565 8.31607 9.55871 8.87868 10.1213C9.44129 10.6839 10.2044 11 11 11C11.7956 11 12.5587 10.6839 13.1213 10.1213C13.6839 9.55871 14 8.79565 14 8C14 7.20435 13.6839 6.44129 13.1213 5.87868C12.5587 5.31607 11.7956 5 11 5ZM11 13C9.67392 13 8.40215 12.4732 7.46447 11.5355C6.52678 10.5979 6 9.32608 6 8C6 6.67392 6.52678 5.40215 7.46447 4.46447C8.40215 3.52678 9.67392 3 11 3C12.3261 3 13.5979 3.52678 14.5355 4.46447C15.4732 5.40215 16 6.67392 16 8C16 9.32608 15.4732 10.5979 14.5355 11.5355C13.5979 12.4732 12.3261 13 11 13ZM11 0.5C6 0.5 1.73 3.61 0 8C1.73 12.39 6 15.5 11 15.5C16 15.5 20.27 12.39 22 8C20.27 3.61 16 0.5 11 0.5Z" fill="white" />
                                    </svg>
                                </button>
                                <span class="text-danger text-start d-flex mt-1 cngPwd" id="confPwd" style="font-size: 12px;"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="login-btn mt-4 ms-0" type="button" id="changePassword" style="width: 280px;">
                    {{__('Continue')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                    </svg>
                </button>
            </form>
        </div>

    </div>
</div>