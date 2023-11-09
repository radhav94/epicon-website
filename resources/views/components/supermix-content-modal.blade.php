<div class="modal fade" id="supermixModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered px-3">
        <div class="modal-content">
            <button class="x-btn bg-transparent text-white closebtn position-absolute" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z" fill="#F8F8F8" />
                </svg>
            </button>
            <div class="modal-body">

                {{-- start supermix page --}}
                <div class="w-100">
                    <section class="container-fluid w-100 mt-2">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <div class="supermix-main w-100">
                                    <div class="supermix-banner w-100 mb-4" id="supermix-banner-video">
                                        <video id="vidPlayer" controls crossorigin playsinline poster="" style="width:100%"></video>
                                    </div>
                                    <div class="supermix-banner w-100 mb-4" id="supermix-banner-img">
                                        <img src="#" alt="banner">
                                        <button class="story-play-btn" id="" style="display:none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                                <path d="M30.25 19.9977L30.25 20.0023C30.2504 20.1664 30.2104 20.3252 30.1374 20.4625C30.0645 20.5996 29.9629 20.7076 29.8479 20.7811L29.8479 20.7811L29.8431 20.7841L13.4704 31.3774L13.47 31.3776C13.3477 31.4569 13.2125 31.4972 13.0782 31.4999C12.944 31.5025 12.8081 31.4675 12.684 31.3936L12.6817 31.3923C12.5597 31.3201 12.4511 31.2106 12.3725 31.0693C12.2939 30.9278 12.2503 30.7626 12.25 30.5912V9.40877C12.2503 9.2374 12.2939 9.07222 12.3725 8.93074C12.4511 8.7894 12.5597 8.6799 12.6817 8.60774L12.6817 8.60775L12.684 8.60638C12.8081 8.53254 12.944 8.49751 13.0782 8.50014C13.2125 8.50277 13.3477 8.54314 13.47 8.62239L13.4704 8.62263L29.8431 19.2159L29.8431 19.2159L29.8479 19.2189C29.9629 19.2924 30.0645 19.4004 30.1374 19.5375C30.2104 19.6748 30.2504 19.8336 30.25 19.9977Z" stroke="white" stroke-width="2" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="podcast-btns d-flex align-items-center">
                                        <button class="fill-btn spr-mix ms-0 px-4 me-2" id="supermixWatchBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                                                <path d="M26.75 14.0005C26.7507 14.2976 26.6745 14.5899 26.5289 14.8488C26.3832 15.1077 26.173 15.3246 25.9188 15.4782L10.16 25.1185C9.89431 25.2812 9.59001 25.37 9.27852 25.3758C8.96703 25.3816 8.65965 25.3041 8.38813 25.1513C8.11918 25.001 7.89515 24.7817 7.73905 24.516C7.58296 24.2503 7.50045 23.9479 7.5 23.6398V4.36133C7.50045 4.0532 7.58296 3.75076 7.73905 3.48509C7.89515 3.21943 8.11918 3.00014 8.38813 2.84976C8.65965 2.69702 8.96703 2.61953 9.27852 2.6253C9.59001 2.63107 9.89431 2.71989 10.16 2.88258L25.9188 12.5229C26.173 12.6765 26.3832 12.8934 26.5289 13.1523C26.6745 13.4112 26.7507 13.7035 26.75 14.0005Z" fill="#272727" />
                                            </svg> &nbsp;
                                            {{__('Watch')}}
                                        </button>
                                        {{-- <button class="rounded-grey-btn me-2"><img src="public/img/add-icon.svg" alt="icon"></button> --}}
                                        <button class="rounded-grey-btn me-2 shuffleContent">
                                            <img src="{{ asset('assets/img/shuffle-icon.svg') }}" alt="icon">
                                        </button>
                                        {{-- <button class="rounded-grey-btn me-2"><img src="public/img/clap-icon.svg"  alt="icon"></button> --}}
                                        {{-- <button class="rounded-grey-btn"><img src="public/img/share-icon.svg" alt="icon"></button> --}}
                                    </div>


                                    <div id="supermixData">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                {{-- end supermix page --}}

            </div>
        </div>
    </div>
</div>