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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M20.9593 2.95892L19.4551 1.52148L2.50101 19.2627L4.00518 20.7002L20.9593 2.95892Z" fill="white"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z" fill="white"/></svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M20.9593 2.95892L19.4551 1.52148L2.50101 19.2627L4.00518 20.7002L20.9593 2.95892Z" fill="white"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z" fill="white"/></svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M20.9593 2.95892L19.4551 1.52148L2.50101 19.2627L4.00518 20.7002L20.9593 2.95892Z" fill="white"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M17.9555 6.11126C16.2071 5.08712 14.1725 4.5 12 4.5C7 4.5 2.73 7.61 1 12C2.03885 14.6362 3.99362 16.8108 6.47236 18.1276L8.72091 15.7746C8.63295 15.6982 8.5474 15.6185 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C15.5648 8.49369 15.5936 8.52324 15.622 8.5531L17.9555 6.11126ZM14.2376 10.0017C14.2001 9.95975 14.1613 9.91871 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C9.95102 14.1937 10.0267 14.2619 10.1053 14.326L14.2376 10.0017ZM12.2365 14.9907L14.9983 12.1006C14.9729 12.8597 14.6602 13.5825 14.1213 14.1213C13.6147 14.6279 12.9456 14.9346 12.2365 14.9907ZM10.528 16.7784C11.0006 16.924 11.4964 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 11.4194 16.899 10.8491 16.7067 10.3128L19.6065 7.27847C21.0968 8.53554 22.2728 10.1547 23 12C21.27 16.39 17 19.5 12 19.5C10.7619 19.5 9.5685 19.3093 8.44738 18.9557L10.528 16.7784Z" fill="white"/></svg>
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