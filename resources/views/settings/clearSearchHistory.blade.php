<div class="tab-pane text-white fade" id="v-pills-clear-search-history" role="tabpanel" aria-labelledby="v-pills-clear-search-history-tab">
    <div class="language-setting">
        <h4 class="pb-4 border-bot">{{__('Clear your search history')}}</h4>

        <div class="childpin text-start py-4">

            <div id="clearHistoryDiv" class="sync-device-main pb-4 w-100">
                <div>
                    <p class="my-3">{{__('Are you sure you want to clear all your search history?')}}</p>
                    <button class="login-btn mt-4 ms-0" style="width: 100px;" id="clearSearchBtn">
                        {{__('Yes')}}
                    </button>
                </div>
                <img class="mb-4" width="150" src="{{ env('AWS_S3_domain').'epicon/assets/images/clear-icon.svg' }}" alt="icon">
            </div>
            <div id="browseHistoryDiv" class="w-100 text-center mt-4">
                <img width="300" src="{{ env('AWS_S3_domain').'epicon/assets/images/clear-history-bg.svg' }}" alt="img">
                <p>{{__('You do not have any recent search history.')}}</p>
                <button class="login-btn mt-4" style="width: 250px;" id="searchBrowseBtn">
                    {{__('Browse Now')}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.25 12C4.25 11.5858 4.58579 11.25 5 11.25H19C19.4142 11.25 19.75 11.5858 19.75 12C19.75 12.4142 19.4142 12.75 19 12.75H5C4.58579 12.75 4.25 12.4142 4.25 12Z" fill="#070707"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 4.46967C11.7626 4.17678 12.2374 4.17678 12.5303 4.46967L19.5303 11.4697C19.8232 11.7626 19.8232 12.2374 19.5303 12.5303L12.5303 19.5303C12.2374 19.8232 11.7626 19.8232 11.4697 19.5303C11.1768 19.2374 11.1768 18.7626 11.4697 18.4697L17.9393 12L11.4697 5.53033C11.1768 5.23744 11.1768 4.76256 11.4697 4.46967Z" fill="#070707"></path>
                    </svg>
                </button>
            </div>

        </div>

    </div>
</div>