   <?php
    $season_episode_data = [];
    $temp = $seasonList = [];
    $tab1_title = $lastSeason = '';

    if ($content['content_type'] == 'SHOW') {
        $content_order = false;
        $seasons = $content['season'] ?? [];
        $tab1_title = 'Seasons';
        foreach ($seasons as $value) {            
            $temp = $value['episodes'] ?? [];
            $temp = sortEpisodes($temp);
            //$lastSeason = $value['slug'];
            if ($temp != null) {
                if (isset($value['content_order'])) {
                    $content_order = true;
                    $seasonList[$value['content_order']] = [
                        'title' => $value['title'],
                        'url' => $value['slug'],
                        'content_order' => $value['content_order']
                    ];
                } else {
                    $seasonList[] = [
                        'title' => $value['title'],
                        'url' => $value['slug']
                    ];
                }
                
                $season_episode_data[$value['slug']] = $temp;
            }
        }
        $tab1_title = 'Episodes';
        $content_order ? krsort($seasonList) : rsort($seasonList);
    } elseif ($content['content_type'] == 'SEASON') {
        $temp = $content['episodes'] ?? [];
        $temp = sortEpisodes($temp);
        $tab1_title = 'Episodes';
        //$lastSeason = @$content['slug'];
        $season_episode_data[$lastSeason] = $temp;
    }elseif ($content['content_type'] == 'EPISODE') {
        $temp = $content['season'][0]['episodes'] ?? [];
        $temp = sortEpisodes($temp);
        $tab1_title = 'Episodes';
        $lastSeason = @$content['slug'];
        if($temp){
         $season_episode_data[$lastSeason] = $temp;
        }
    }

    $active_tab = '';
    $tabs = [];

    if ($season_episode_data) {
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
                   <ul class="nav nav-pills border-bot pb-3" id="pills-tab" role="tablist">

                       @foreach ($tabs as $key => $value)
                       <?php
                        if ($key == 0) {
                            $active_tab = $value['key'];
                        }
                        ?>
                       <li class="nav-item" role="presentation">
                           <h2 class="nav-link {{ $key == 0 ? 'ep active' : '' }}" id="{{ $value['key'] }}" data-bs-toggle="pill" data-bs-target="#pills-{{ $value['key'] }}" type="button" role="tab" aria-controls="pills-{{ $value['key'] }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ __($value['title']) }}</h2>
                       </li>
                       @endforeach


                       <!-- filter -->
                       <div class="episode-season">
                       @if($content['content_type'] !="VIDEO")
                       <div class="all-episode season">
                               <select id="SortingEp">
                                   <option value="asc" selected>Sort by Oldest</option>
                                   <option value="desc">Sort by Newest</option>
                               </select>
                        </div>
                        @endif
                           @if (count($seasonList) > 0)
                           <div class="season">
                               <select id="seasonSelect">
                                   <!-- <option value="0">{{__('All Seasons')}}</option> -->
                                   @foreach ($seasonList as $key => $season)
                                   <option value="{{ $season['url'] }}" <?php echo ($key == 0) ? 'selected="selected"' : ''; ?>>{{ $season['title'] }}</option>
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
   <script>
    var user_duration = "{{ $content['user_duration'] ?? 0}}";
   </script>