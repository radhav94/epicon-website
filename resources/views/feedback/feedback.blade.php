@extends('layouts.default')
@section('title','Help & Feedback')

@section('style')

@stop

@section('content')

<section class="helps-feedback container w-100 my-4">
    <div class="row justify-content-center">

        <div class="col-sm-12 border-bot">
            <h4 class="text-white mb-4">Help & Feedback</h4>
        </div>
        <div class="col-sm-12">
            <div class="w-100 mb-5 mt-4">
                <div class="search-header">
                    <div class="inside-head">
                        <img src="{{ asset('/img/search-white.png') }}" alt="">
                        <input type="text" placeholder="How can we help you today?">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <h4 class="text-white mb-4">Frequently Asked Questions</h4>
        </div>
        <div class="faq-accordian col-sm-12 mb-5">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item border-bot">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Does Epic On provide content for kids also?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body text-white">
                            Epic's library has been carefully curated with content from only the most reputable and respected partners like National Geographic Kids and Sesame Workshop, so children have access to the highest quality content available.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            How to change preferences?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body text-white">
                            Epic's library has been carefully curated with content from only the most reputable and respected partners like National Geographic Kids and Sesame Workshop, so children have access to the highest quality content available.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            How many languages are available on Epic ON?
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body text-white">
                            Epic's library has been carefully curated with content from only the most reputable and respected partners like National Geographic Kids and Sesame Workshop, so children have access to the highest quality content available.
                        </div>
                    </div>
                </div>
                <div class="accordion-item border-bot">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                        <button class="accordion-button collapsed text-white" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                            Service availability
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                        <div class="accordion-body text-white">
                            Epic's library has been carefully curated with content from only the most reputable and respected partners like National Geographic Kids and Sesame Workshop, so children have access to the highest quality content available.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="feedbackForm">
            <div class="col-sm-12">
                <h4 class="text-white mb-4">Need More Help?</h4>
            </div>
            <div class="col-sm-12 need-help">
                <p class="para-help">Write your query/feedback below and we will reach out to you within 24 hours.</p>
                <textarea name="feedback" id="" cols="122" rows="5" placeholder="Type your query here..."></textarea>
                <div class="error-msg" style="color: red;"></div>
                <div class="success-msg" style="color: green;"></div>
            </div>
            <button type="button" class="need-button">
                Submit
                <span><svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.94922 12C4.94922 11.5858 5.28501 11.25 5.69922 11.25H19.6992C20.1134 11.25 20.4492 11.5858 20.4492 12C20.4492 12.4142 20.1134 12.75 19.6992 12.75H5.69922C5.28501 12.75 4.94922 12.4142 4.94922 12Z" fill="#070707" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1689 4.46967C12.4618 4.17678 12.9367 4.17678 13.2295 4.46967L20.2295 11.4697C20.5224 11.7626 20.5224 12.2374 20.2295 12.5303L13.2295 19.5303C12.9367 19.8232 12.4618 19.8232 12.1689 19.5303C11.876 19.2374 11.876 18.7626 12.1689 18.4697L18.6386 12L12.1689 5.53033C11.876 5.23744 11.876 4.76256 12.1689 4.46967Z" fill="#070707" />
                    </svg></span>
            </button>
        </form>
    </div>

</section>

@stop

@section('script')

<script>
    $(document).ready(function() {
        $("#feedbackForm button").click(function() {
            $("#feedbackForm .success-msg, #feedbackForm .error-msg").html("");
            var feedback = $("#feedbackForm textarea").val();
            if (feedback.trim() == "") {
                $("#feedbackForm .error-msg").html("Query/Feedback is required");
                return;
            }
            var formData = $('#feedbackForm').serialize();
            if (formData != '') {
                $.ajax({
                    url: "{{ route('save-feedback') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.payload.success == true) {
                            $("#feedbackForm textarea").val('');
                            $("#feedbackForm .success-msg").html("Your Feedback updated. We will reach out to you within 24 hours.");
                        } else {
                            if (response.payload.errorcode == "2002") {
                                $("#feedbackForm .error-msg").html("You are not logged in.");
                            } else {
                                $("#feedbackForm .error-msg").html(response.payload.message);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('error me aaya');
                    }
                });
            } else {
                $("#feedbackForm #error-msg").html("Please type your query.");
            }
        })
    });
</script>

@stop