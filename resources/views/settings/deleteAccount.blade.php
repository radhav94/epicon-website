<div class="tab-pane text-white fade" id="v-pills-delete-account" role="tabpanel" aria-labelledby="v-pills-delete-account-tab">
    <div class="language-setting">
        <h4 class="pb-4 border-bot">{{__('Permanently delete your account')}}</h4>

        <div class="childpin text-start py-4">

            <div class="sync-device-main pb-4 w-100">
                <div>
                    <p class="delete-text my-3">{{__('Deleting your account will delete all your saved content. You will also lose any subscription linked to your account. You can chose to log out instead. This will allow you to come back any time you wish.')}}</p>
                    <div class="d-flex mt-4">
                        <button class="border-btn my-0" id="delete_user_account">{{__('Delete Acc')}}</button>
                        <button class="fill-btn logout mt-0 my-0">{{__('Log Out')}}</button>
                    </div>
                </div>
                <img class="mb-4" width="150" src="{{ asset('/img/delete-account-icon.svg') }}" alt="icon">
            </div>

        </div>

    </div>
</div>