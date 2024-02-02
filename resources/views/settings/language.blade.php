<div class="tab-pane text-white fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    <div class="language-setting">
        <h4 class="pb-4 border-bot">{{ __('Manage your language preferences') }} </h4>

        <div class="display-language">
            <p>{{ __('Display Language') }}</p>
            <div>
                <div class="form-check mb-4">
                    <input class="form-check-input me-2" type="radio" name="displayLang" id="exampleRadios2" value="en" <?php if ($displayLanguage == 'en') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                    <label class="form-check-label" for="exampleRadios2">
                        {{ __('English') }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input me-2" type="radio" name="displayLang" id="exampleRadios3" value="hi" <?php if ($displayLanguage == 'hi') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                    <label class="form-check-label" for="exampleRadios3">
                        {{ __('Hindi')}}
                    </label>
                </div>
            </div>
        </div>

       {{-- <div class="display-language pb-0">
            <p>{{ __('Content Language') }}</p>
            <div>
                <div class="form-check mb-4">
                    <input class="form-check-input me-2" type="radio" name="contentLang" id="exampleRadios7" value="all" </?php if ($listLanguage == 'all') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                    <label class="form-check-label" for="exampleRadios7">
                        {{__('All')}}
                    </label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input me-2" type="radio" name="contentLang" id="exampleRadios8" value="en" </?php if ($listLanguage == 'en') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                    <label class="form-check-label" for="exampleRadios8">
                        {{ __('English') }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input me-2" type="radio" name="contentLang" id="exampleRadios9" value="hi" </?php if ($listLanguage == 'hi') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                    <label class="form-check-label" for="exampleRadios9">
                        {{__('Hindi')}}
                    </label>
                </div>
            </div>
        </div> --}}
    </div>
</div>