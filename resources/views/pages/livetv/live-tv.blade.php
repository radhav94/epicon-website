@extends('layouts.default')
@section('title','LIVE TV')

@section('style')

@stop

@section('content')
<?php //dd($response); ?>
<!-- Live TV Start -->
<section class="livetv-wrapper pt-3">
  <div class="container" style="max-width:100%;">
    <div class="livetv-wrap" style="flex-wrap:inherit;">
      <div class="row">
        <?php if (env('IS_ISHARA_LIVE_TV_SHOW') == true) { ?>
          <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
            <div class="livetv-box premium all text-center">
              <div class="livetv">
                <div class="livetc-right">
                  <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/ishara.png" alt="ishara tv" width="140">
                </div>
                <h3><span>{{__('text.livetv-four')}}</span></h3>
                <div class="livetv-img-container">
                  <!-- <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/live-ishara-tv-1.png" alt="" class="livetv-img"> -->
                  <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/Ishara.png" alt="" class="livetv-img">
                </div>
                <?php
                if ($displayLanguageParam != 'ENGLISH') {
                  $fourlive_url = url(app()->getLocale() . '/' . $response[0]['url']);
                } else {
                  $fourlive_url = url('/' . $response[0]['url']);
                }
                $fourlive_url_final = env('ISHARA_LIVE_TV_LINK', $fourlive_url);
                ?>
                <a href="{{$fourlive_url_final}}" class="play-btn ct-livetv-clicked" ct-livetv-type="IsharaTv">{{__('text.livetv-start')}}</a>
              </div>
            </div>
          </div>
        <?php } ?>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
          <div class="livetv-box premium all text-center">

            <div class="livetv">
              <div class="livetc-right">
                <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/epic-tv-new.png" alt="" width="150">
              </div>
              <h3><span>{{__('text.livetv-first')}}</span></h3>
              <div class="livetv-img-container">
                <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/Epic_livetv.png" alt="" class="livetv-img">
              </div>
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $firstlive_url = url(app()->getLocale() . '/' . $response[1]['url']);
              } else {
                $firstlive_url = url('/' . $response[1]['url']);
              }
              ?>
              <a href="{{$firstlive_url}}" class="play-btn ct-livetv-clicked" ct-livetv-type="EpicTv">{{__('text.livetv-start')}}</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
        <div class="livetv-box free all text-center">

          <div class="livetv">
            <div class="livetc-right">
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $filamchinewlogo = '/img/filamchi-logo-hindi.png';
              } else {
                $filamchinewlogo = '/img/new_filamchi_logo.png';
              }
              ?>
              <img src="{{config('epicconfig.ASSET.ASSET_URL')}}{{$filamchinewlogo}}" alt="" width="200">
              <div class="clear"></div>
            </div>
            <h3><span>{{__('text.livetv-third')}}</span></h3>
            <div class="livetv-img-container filamchi">
              <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/Filamchi_livetv.png" alt="" class="livetv-img">
            </div>
            <?php
            if ($displayLanguageParam != 'ENGLISH') {
              $thirdlive_url = url(app()->getLocale() . '/' . $response[2]['url']);
            } else {
              $thirdlive_url = url('/' . $response[2]['url']);
            }
            ?>
            <a href="{{$thirdlive_url}}" class="play-btn ct-livetv-clicked" ct-livetv-type="Filamchi">{{__('text.livetv-start')}}</a>
          </div>
        </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
        <div class="livetv-box free all text-center">

          <div class="livetv">
            <div class="livetc-right">
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $showboxnewlogo = '/img/new-show-box-logo-hindi.png';
              } else {
                $showboxnewlogo = '/img/new-show-box-logo.png';
              }
              ?>
              <img src="{{config('epicconfig.ASSET.ASSET_URL')}}{{$showboxnewlogo}}" alt="" width="200">
            </div>
            <h3><span>{{__('text.livetv-second')}}</span></h3>
            <div class="livetv-img-container">
              <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/Showbox_livetv.png" alt="" class="livetv-img">
            </div>
            <?php
            if ($displayLanguageParam != 'ENGLISH') {
              $secondlive_url = url(app()->getLocale() . '/' . $response[3]['url']);
            } else {
              $secondlive_url = url('/' . $response[3]['url']);
            }
            ?>
            <a href="{{$secondlive_url}}" class="play-btn ct-livetv-clicked" ct-livetv-type="ShowBox">{{__('text.livetv-start')}}</a>
          </div>
        </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
        <?php if (env('IS_GUBBARE_LIVE_TV_SHOW') == true) { ?>
          <div class="livetv-box free all text-center">

            <div class="livetv">
              <div class="livetc-right">
                <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/gubbare-logo.png" alt="" width="200">
              </div>
              <h3><span>{{__('text.livetv-five')}}</span></h3>
              <div class="livetv-img-container">
                <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/Gubbare_livetv.png" alt="" class="livetv-img">
              </div>
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $secondlive_url = url(app()->getLocale() . '/' . $response[4]['url']);
              } else {
                $secondlive_url = url('/' . @$response[4]['url']);
              }
              ?>
              <a href="{{$secondlive_url}}" class="play-btn ct-livetv-clicked" ct-livetv-type="ShowBox">{{__('text.livetv-start')}}</a>
            </div>
          </div>
        <?php } ?>
        </div>
        <?php if (env('IS_NAZARA_LIVE_TV_SHOW') == true) { ?>
          <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
            <div class="livetv-box premium all text-center">
              <div class="livetv">
                <div class="livetc-right">
                  <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/nazara-logo.png" alt="" width="140">
                </div>
                <h3><span>{{__('text.livetv-four')}}</span></h3>
                <div class="livetv-img-container">
                  <img src="{{config('epicconfig.ASSET.ASSET_URL')}}/img/Nazara_livetv.png" alt="" class="livetv-img">
                </div>
                <?php
                if ($displayLanguageParam != 'ENGLISH') {
                  $fourlive_url = url(app()->getLocale() . '/' . $response[5]['url']);
                } else {
                  $fourlive_url = url('/' . $response[5]['url']);
                }
                $fourlive_url_final = env('ISHARA_LIVE_TV_LINK', $fourlive_url);
                ?>
                <a href="{{$fourlive_url_final}}" class="play-btn ct-livetv-clicked" ct-livetv-type="NazaraTv">{{__('text.livetv-start')}}</a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<!-- Live TV Stop -->
@stop

@section('script')
  <script>
    $(document).ready(function() {
       $("#redeem-popup").hide();
      $(".Redeembtn").click(function(e) {
            e.preventDefault();
            // alert("clicked on redeem");
            
            var formData = $('#redeem_coupon').val();
            $('.redeem-code').html(formData);
            var requestData = {
                coupon_code: formData
            };
            $.ajax({
                url: '{{ route('redeemcoupon') }}',
                type: 'POST',
                data: requestData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log("on success");
                    if(response.payload.success == true){
                        $("#redeem-popup").show();
                        setTimeout(function() {
                            location.reload();
                        }, 2000); // Refresh every 5000 milliseconds (5 seconds)
                    }else{
                        showToaster(response.payload.response.message, 2);
                      // console.log("on fail");  
                    }
                    
                },
                error: function(xhr, status, error) {}
            });
        });

      $(".btn-close").click(function() {
            $('#redeem-popup').hide();
        });

  });
  </script>
@stop