@extends('layouts.default')
@section('title', $meta['title'] ?? getDefaultMetaTitle() )

@section('style')
<style>

    .play-button{
        width: 35px;
        height: 35px;
        position: absolute;
        background-color:black;
        border: 1px solid #fff;
        border-radius:50%;
        cursor: pointer;
        opacity: 0;
        pointer-events: none;
    }
    .play-button img{
        width: 9px !important;
        height: 14px !important;
        margin: 10px auto;
    }
    .distro-slider .sample_img{
        border-radius:15px;
        overflow:visible;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sample_img:hover{
        transform: scale(1.2, 1.2);
        transform-origin: center;
        position: relative;
        z-index: 9;
    }
    .sample_img:hover .play-button{
        opacity: 1;
    }
    .distro-search-img img{
        width: 100%;
        height:100%;
        object-fit:cover;
    }
    .npq.active
    {
        background: #ffffff1a;
        color: #fff;
    }
</style>
@stop

@section('content')
<input type="hidden" id="routepage" value="{{ request()->path() }}">
<input type="hidden" id="pageval" value="1">


<div class="loadmorecontent">

    <?php
         $wishlist = getWishlist();
         //dd($result['pageData']);
         ?>

         @if (@$result['pageData']['list'])
             @foreach ($result['pageData']['list'] as $key => $value)
                 @if (isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
                     @php
                         $template = 'display-distro.' . $value['display_type'];
                     @endphp

                    @if (View::exists($template))
                         <?php
                         $title = getDispLangContent($value, $displayLanguageParam, 'title');
                         $shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
                         
                         ?>

                         @if (request()->get('v'))
                             <h1>{{ $value['display_type'] }}</h1>
                         @endif

               
                            @include($template, [
                                'value' => $value,
                                'title' => $title,
                                'shortdescription' => sanitizeData($shortdescription),
                            ])
                     @endif
                 @endif
             @endforeach
         @endif

</div>

    <div class="content-loader d-none" style="text-align: center;"> <img style="width: 40px;" src="{{ env('AWS_S3_domain') }}epicon/assets/images/loader.gif" alt="loading"> </div>
<div class="modal fade" id="epg-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered px-3">
        <div class="modal-content">
            <button class="x-btn text-white closebtn position-absolute btn-close redi-subs" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 31 32" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4212 8.60204C24.5304 8.48816 24.6171 8.35293 24.6763 8.20408C24.7355 8.05524 24.766 7.89568 24.7661 7.73453C24.7662 7.57338 24.7359 7.41378 24.6769 7.26486C24.6179 7.11593 24.5313 6.9806 24.4222 6.86657C24.313 6.75255 24.1834 6.66208 24.0408 6.60031C23.8982 6.53855 23.7453 6.50671 23.5908 6.50661C23.4364 6.50651 23.2834 6.53816 23.1407 6.59974C22.998 6.66132 22.8683 6.75162 22.759 6.86551L15.6668 14.266L8.57671 6.86551C8.35603 6.63523 8.05672 6.50586 7.74462 6.50586C7.43253 6.50586 7.13322 6.63523 6.91253 6.86551C6.69185 7.09579 6.56787 7.40811 6.56787 7.73377C6.56787 8.05944 6.69185 8.37176 6.91253 8.60204L14.0047 16.0004L6.91253 23.3988C6.80326 23.5129 6.71658 23.6482 6.65745 23.7972C6.59831 23.9462 6.56787 24.1059 6.56787 24.2671C6.56787 24.4284 6.59831 24.588 6.65745 24.737C6.71658 24.886 6.80326 25.0214 6.91253 25.1354C7.13322 25.3657 7.43253 25.495 7.74462 25.495C7.89916 25.495 8.05218 25.4633 8.19495 25.4016C8.33772 25.3398 8.46744 25.2494 8.57671 25.1354L15.6668 17.7348L22.759 25.1354C22.9797 25.3654 23.2789 25.4945 23.5908 25.4943C23.9027 25.4941 24.2018 25.3646 24.4222 25.1343C24.6426 24.904 24.7663 24.5918 24.7661 24.2664C24.7659 23.9409 24.6418 23.6288 24.4212 23.3988L17.329 16.0004L24.4212 8.60204Z" fill="#F8F8F8" />
                </svg>
            </button>

            <div class="modal-body">
                <div class="epg-data" id="epg-data">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script src="{{ env('AWS_S3_domain') }}epicon/assets/images/homepage.js?v={{ assetTime() }}"></script>
<script defer src="{{ env('AWS_S3_domain').'epicon/assets/images/distro-tv.js' }}?v={{ assetTime() }}"></script>
<script>
    window.onload = function() {
        eventAfterDistroLoad();
    }
    var processing;
    var spinnerAdded = false;

    $(document).ready(function() {
        $('#pageval').val('1');
        
        if (typeof activateSpinner === 'function') {
            activateSpinner();
        }
        initSliders();

        });
    function fetchBannerDetails(episode_id, content_provider_id, description, root_img_poster){
            console.log("button modal clicked", episode_id, content_provider_id);
            // URL endpoint where data will be sent
            const url = `{{route('distro-tv-epg')}}`;
            console.log(url);
            // Data you want to send
            const data = {
                episode_id: episode_id,
                content_provider_id: content_provider_id,
                description: description,
                root_img_poster: root_img_poster
            };

            // Using fetch with a POST request
            document.body.style.cursor = 'wait';
            fetch(url, {
                method: 'POST', // Specify POST method
                headers: {
                    'Content-Type': 'application/json', // Specify content type
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Optional, for Laravel CSRF tokens
                },
                body: JSON.stringify(data) // Convert data to JSON format for sending
            })
            .then(response => {
                document.body.style.cursor = 'default';
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                // console.log('Success:', data.html); // Handle response data 
                $('#epg-data').html(data.html);
                $('#epg-modal').modal('show');
            })
            .catch(error => {
                console.error('Error:', error); // Handle errors
            });

    }
    </script>
    

@stop
