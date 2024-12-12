<!-- better suggetion start -->
<div class="login-popup-modal better-solution choose-interests">
    <form id="interestsSuggestions" class="better-solution">
        <div class="bs-left">
            <h4>
                Choose 5 interests for better suggestions
            </h4>
            <div class="choose">
                <div class="three">
                    <span><img src="{{ env('AWS_S3_domain').'epicon/assets/images/welcom.jpeg'}}" alt=""></span>
                    <span><img src="{{ env('AWS_S3_domain').'epicon/assets/images/dhamal.jpeg'}}" alt=""></span>
                    <span><img src="{{ env('AWS_S3_domain').'epicon/assets/images/welcom.jpeg'}}" alt=""></span>
                    <span class="span-text-3 genre-select-count">0 of 5</span>
                </div>
                <button type="button" class="better-suggestion-nxtBtn">Next
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 12H19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 5L19 12L12 19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <input type="hidden" name="user_token">
            </div>
            <div id="error-meg-for-genre-select" style="color: red;"></div>
        </div>
        <div class="bs-right" id="interest-suggetion">
        </div>
    </form>
</div>
<!-- better suggetion end -->