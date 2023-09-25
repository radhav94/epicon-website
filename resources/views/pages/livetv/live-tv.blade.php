@extends('layouts.default')
@section('title','LIVE TV')

@section('style')

@stop

@section('content')
<?php //dd($response); 
?>
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
                <img src="{{ asset('/img/ishara-logo.png')}}" alt="ishara tv" width="140">
              </div>
              <h3><span>Hindi Entertainment Channel</span></h3>
              <div class="livetv-img-container">
                <img src="{{ asset('/img/Ishara_livetv.png') }}" alt="" class="livetv-img">
              </div>
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $fourlive_url = url(app()->getLocale() . '/' . $response[0]['url']);
              } else {
                $fourlive_url = url('/' . $response[0]['url']);
              }
              $fourlive_url_final = env('ISHARA_LIVE_TV_LINK', $fourlive_url);
              ?>
              <a href="{{ $fourlive_url_final }}" class="play-btn ct-livetv-clicked" ct-livetv-type="IsharaTv">Start Live TV</a>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
          <div class="livetv-box premium all text-center">
            <div class="livetv">
              <div class="livetc-right">
                <img src="{{ asset('/img/epic-tv.png') }}" alt="ishara tv" width="140">
              </div>
              <h3><span>India Ka Apna Infotainment</span></h3>
              <div class="livetv-img-container">
                <img src="{{ asset('/img/Epic_livetv.png') }}" alt="" class="livetv-img">
              </div>
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $firstlive_url = url(app()->getLocale() . '/' . $response[1]['url']);
              } else {
                $firstlive_url = url('/' . $response[1]['url']);
              }
              ?>
              <a href="{{ $firstlive_url }}" class="play-btn ct-livetv-clicked" ct-livetv-type="IsharaTv">Start Live TV</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
          <div class="livetv-box premium all text-center">
            <div class="livetv">
              <div class="livetc-right">
              <?php
                if ($displayLanguageParam != 'ENGLISH') {
                  $filamchinewlogo = '/img/filamchi-logo-hindi.png';
                } else {
                  $filamchinewlogo = '/img/new_filamchi_logo.png';
                }
                ?>
                <img src="{{ asset($filamchinewlogo) }}" alt="ishara tv" width="140">
              </div>
              <h3><span>Bhojpuri Movie Channel</span></h3>
              <div class="livetv-img-container">
                <img src="{{ asset('/img/Filamchi_livetv.png') }}" alt="" class="livetv-img">
              </div>
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $thirdlive_url = url(app()->getLocale() . '/' . $response[2]['url']);
              } else {
                $thirdlive_url = url('/' . $response[2]['url']);
              }
              ?>
              <a href="{{$thirdlive_url}}" class="play-btn ct-livetv-clicked" ct-livetv-type="IsharaTv">Start Live TV</a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
          <div class="livetv-box premium all text-center">
            <div class="livetv">
              <div class="livetc-right">
              <?php
                if ($displayLanguageParam != 'ENGLISH') {
                  $showboxnewlogo = '/img/new-show-box-logo-hindi.png';
                } else {
                  $showboxnewlogo = '/img/new-show-box-logo.png';
                }
                ?>
                <img src="{{ asset($showboxnewlogo) }}" alt="Show Box" width="140">
              </div>
              <h3><span>Youth Centric Music Channel</span></h3>
              <div class="livetv-img-container">
                <img src="{{ asset('/img/Showbox_livetv.png') }}" alt="" class="livetv-img">
              </div>
              <?php
              if ($displayLanguageParam != 'ENGLISH') {
                $secondlive_url = url(app()->getLocale() . '/' . $response[3]['url']);
              } else {
                $secondlive_url = url('/' . $response[3]['url']);
              }
              ?>
              <a href="{{ $secondlive_url }}" class="play-btn ct-livetv-clicked" ct-livetv-type="IsharaTv">Start Live TV</a>
            </div>
          </div>
        </div>
        <?php if (env('IS_GUBBARE_LIVE_TV_SHOW') == true) { ?>
        <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
          <div class="livetv-box premium all text-center">
            <div class="livetv">
              <div class="livetc-right">
                <img src="{{ asset('/img/gubbare-logo.png') }}" alt="ishara tv" width="140">
              </div>
              <h3><span>Kids Channel</span></h3>
              <div class="livetv-img-container">
                <img src="{{ asset('/img/Gubbare_livetv.png') }}" alt="" class="livetv-img">
              </div>
              <?php
                if ($displayLanguageParam != 'ENGLISH') {
                  $secondlive_url = url(app()->getLocale() . '/' . $response[4]['url']);
                } else {
                  $secondlive_url = url('/' . @$response[4]['url']);
                }
                ?>
              <a href="" class="play-btn ct-livetv-clicked" ct-livetv-type="IsharaTv">Start Live TV</a>
            </div>
          </div>
        </div>
        <?php } ?>
        <?php if (env('IS_NAZARA_LIVE_TV_SHOW') == true) { ?>
          <div class="col-md-6 col-lg-4 col-xl-3 col-xxl-3 mb-5">
            <div class="livetv-box premium all text-center">
              <div class="livetv">
                <div class="livetc-right">
                  <img src="{{ asset('/img/nazara-logo.png') }}" alt="" width="140">
                </div>
                <h3><span>Hindi Entertainment Channel</span></h3>
                <div class="livetv-img-container">
                  <img src="{{ asset('/img/Nazara_livetv.png') }}" alt="" class="livetv-img">
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

  });
</script>
@stop