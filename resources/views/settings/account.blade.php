<div class="tab-pane text-white fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <!-- choose 5 suggetion start -->
    <div class="better-solution">
        <form id="updateInterestForm" class="better-solution">
            <div class="bs-left">
                <h4 class="mb-2">
                    {{__('Manage your preferences')}}
                </h4>
                <p class="small text-start w-100">{{__('Update your interests')}} ({{__('choose 5')}})</p>
                <div class="choose">
                    <div class="three">
                        <span><img src="{{ asset('/img/welcom.jpeg') }}" alt=""></span>
                        <span><img src="{{ asset('/img/dhamal.jpeg') }}" alt=""></span>
                        <span><img src="{{ asset('/img/welcom.jpeg') }}" alt=""></span>
                        <span><img src="{{ asset('/img/dhamal.jpeg') }}" alt=""></span>
                        <span><img src="{{ asset('/img/welcom.jpeg') }}" alt=""></span>
                        <span class="span-text-5 genre-select-count">{{ $interestsCount }} of 5</span>
                    </div>
                    <button type="button" id="updatePreference">{{('Next')}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12H19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 5L19 12L12 19" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div id="error-meg-for-genre-select" style="color: red;"></div>
                <div id="success-meg-for-genre-select" style="color: green;"></div>
            </div>
            <div class="bs-right">
                <?php foreach ($genreList as $genre) { ?>
                    <div class="interest-suggetion width-3">
                        <label class="is-checkbox">
                            <input type="checkbox" name="genreInterest[]" <?php if (in_array($genre['genre'], $interests)) {
                                                                                echo "checked";
                                                                            } ?> value="{{ $genre['genre'] }}">
                            <span class="checkmark"></span>
                        </label>
                        <img src="{{ @$genre['cover_image']['medium'] }}" alt="{{ @$genre['genre'] }}">
                        <div class="is-overlay">
                            <h1>{{ $genre['genre'] }}</h1>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </form>
    </div>
    <!-- choose 5 suggetion end -->
</div>