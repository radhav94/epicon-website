   <?php
    $ep_season_data = $season_episode_data = [];
    $temp = $seasonList = [];

    $tab1_title = $lastSeason = '';
    // dd($content);
    if ($content['content_type'] == 'SHOW') {
        $seasons = $content['season'] ?? [];
        $tab1_title = 'Seasons';
        foreach ($seasons as $value) {
            $seasonList[] = [
                'title' => $value['title'],
                'url' => $value['slug']
            ];
            $temp = $value['episodes'] ?? [];
            $lastSeason = $value['slug'];
            $season_episode_data[$value['slug']] = $temp;
        }
        $tab1_title = 'Episodes';
        rsort($seasonList);
    } elseif ($content['content_type'] == 'SEASON') {
        $temp = $content['episodes'] ?? [];
        $tab1_title = 'Episodes';
    }

    if ($temp) {
        foreach ($temp as $k => $v) {
            if (isset($v['ID'])) {
                $ep_season_data[] = $v;
            }
        }
    }

    $active_tab = '';
    $tabs = [];

    if ($ep_season_data) {
        $tabs[] = ['key' => "episode", 'title' => $tab1_title];
    }
    if ($morelike) {
        $tabs[] = ['key' => 'morelike', 'title' => 'More like this'];
    }
    if ($trailers && isset($trailers['list']) && !empty($trailers['list'])) {
        $tabs[] = ['key' => 'trailors', 'title' => 'Trailers & More'];
    }
    if ($about) {
        $tabs[] = ['key' => 'about', 'title' => 'About'];
    }

    ?>
   <section class="container w-100 mt-2 mb-4">
       <div class="row justify-content-center">
           <div class="col-sm-12">
               <div class="w-100 library">
                   <ul class="nav nav-pills border-bot pb-3 ps-2" id="pills-tab" role="tablist">

                       @foreach ($tabs as $key => $value)
                       <?php
                        if ($key == 0) {
                            $active_tab = $value['key'];
                        }
                        ?>
                       <li class="nav-item" role="presentation">
                           <button class="nav-link {{ $key == 0 ? 'ep active' : '' }}" id="{{ $value['key'] }}" data-bs-toggle="pill" data-bs-target="#pills-{{ $value['key'] }}" type="button" role="tab" aria-controls="pills-{{ $value['key'] }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ __($value['title']) }}</button>
                       </li>
                       @endforeach


                       <!-- filter -->
                       <div class="episode-season" style="display:block">
                           <!-- <div class="all-episode">
                               <select>
                                   <option value="0">{{__('All Episodes')}}</option>
                                   <option value="1">1 to 50</option>
                                   <option value="2">51 - 100</option>
                                   <option value="3">101 - 150</option>
                                   <option value="4">151 - 200</option>
                               </select>
                           </div> -->
                           @if (count($seasonList) > 0)
                           <div class="season">
                               <select id="seasonSelect">
                                   <!-- <option value="0">{{__('All Seasons')}}</option> -->
                                   @foreach ($seasonList as $key => $season)
                                   <option value="{{ $season['url'] }}" <?php echo ($key == 0) ? 'checked' : ''; ?>>{{ $season['title'] }}</option>
                                   @endforeach
                               </select>
                           </div>
                           @endif
                       </div>
                       <!-- filter end-->
                   </ul>


                   <div class="tab-content" id="pills-tabContent">

                       @if (@$content['asset_type'] == 'LISTEN')
                       @include('pages.detail.detail-components.podcast-episodes')
                       @else
                       @include('pages.detail.detail-components.episodes')
                       @endif

                       @if (@$content['asset_type'] == 'LISTEN')
                       @include('pages.detail.detail-components.podcast-morelike')
                       @else
                       @include('pages.detail.detail-components.morelike')
                       @endif



                       @include('pages.detail.detail-components.trailers')

                       @include('pages.detail.detail-components.about')

                   </div>
               </div>
           </div>
       </div>
   </section>