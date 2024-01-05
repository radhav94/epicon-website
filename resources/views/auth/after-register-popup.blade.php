<div class="modal fade" id="after-register-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered px-3">
        <div class="modal-content">
            <button class="x-btn bg-transparent text-white closebtn position-absolute" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z" fill="#F8F8F8" />
                </svg>
            </button>

            <div class="modal-body">
                <div class="login-register text-center pt-4">
                    @include('auth.genre')
                    @include('auth.setChildPin')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if (queryParams.get('type') == "register") {
            getGenreList();
            $(".login-popup-modal").hide();
            $(".better-solution").show();
            $("#after-register-modal").modal('show');
        }

        //choose genre section
        $('.better-suggestion-nxtBtn').click(function() {
            $("#error-meg-for-genre-select").html("");
            var genreCount = 0;                
            $("input[name='genreInterest[]']").each(function() {
                if (this.checked) {
                    genreCount++;
                }
            });
            if (genreCount > 0 && genreCount != 5) {
                $("#error-meg-for-genre-select").html("Selected genre list should be 5");
            }

            var formData = $('#interestsSuggestions').serialize();
            if (formData != '') {
                $.ajax({
                    url: "{{ route('saveGenre') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.payload.success == true) {
                            $(".login-popup-modal").hide();
                            $(".set-child-pin").show();
                            // location.reload();
                        } else {
                            $("#error-meg-for-genre-select").html(response.payload.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                $('#login-modal').hide();
                $('#login-modal').removeClass("show");
            }
        })

        $("#after-register-modal #setChildPin").click(function() {
            $("#childPinForm #error-msg").html("");
            var formData = $('#childPinForm').serialize();
            var command = $('#childPinForm input[name="command"]').val();
            $.ajax({
                url: "{{ route('set-kidsPin') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.payload.success == true) {
                        var SubchekUrl = localStorage.getItem("SubredirectURL");
                            if(SubchekUrl != "" && SubchekUrl !=null &&  SubchekUrl!=undefined){
                                localStorage.removeItem("SubredirectURL");
                                window.location.href = SubchekUrl;
                                return false;
                                }else{
                                        window.location.href = window.location.origin;
                                        return false;
                                    }
                                }else {
                                    $("#childPinForm #error-msg").html(response.payload.message);
                                }
                },
                error: function(xhr, status, error) {
                    onError(xhr);
                }
            });
        });
    })

    function getGenreList() {
        $('#interest-suggetion').html("")
        $.ajax({
            url: "{{ route('getGenre') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                if (response.payload.success) {
                    var lists = response.payload.response.data;
                    var content = '';
                    for (var i = 0; i < lists.length; i++) {
                        content = '<div class="interest-suggetion">' +
                            '<label class="is-checkbox">' +
                            '<input type="checkbox" name="genreInterest[]" value="' + lists[i]['genre'] + '">' +
                            '<span class="checkmark"></span>' +
                            '</label>' +
                            '<img src="' + lists[i]['banner_image']['medium'] + '" alt="img">' +
                            '<div class="is-overlay">' +
                            '<h1>' + lists[i]['genre'] + '</h1>' +
                            '</div>' +
                            '</div>';
                        $('#interest-suggetion').append(content);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('error me aaya');
            }
        });
    }
</script>