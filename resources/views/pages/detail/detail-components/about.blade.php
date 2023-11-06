 @if ($about)
 <?php
    $temp = [];

    if (@$about['language']) {
        $temp[] = '<h6>' . __('Language') . '</h6> <p>' . $about['language'] . '</p>';
    }
    if (@$about['production']) {
        $temp[] = '<h6>' . __('Production') . '</h6> <p>' . $about['production'] . '</p>';
    }
    if (@$about['realease_date']) {
        $temp[] = '<h6>' . __('Release Date') . '</h6> <p>' . formatDate($about['realease_date']) . '</p>';
    }
    if (@$about['genre']) {
        $temp[] = '<h6>' . __('Genre') . '</h6> <p>' . implode(', ', $about['genre']) . '</p>';
    }
    if (@$about['child_count']) {
        if (@$content['content_type'] == 'SHOW' && !empty(@$content['season'])) {
            $temp[] = '<h6>' . __('Seasons') . '</h6> <p>' . count(@$content['season']) . '</p>';
        } else {
            $temp[] = '<h6>' . __('Episodes') . '</h6> <p>' . $about['child_count'] . '</p>';
        }
    }
    if (@$about['origin_region']) {
        $temp[] = '<h6>'.__('Region of Origin').'</h6> <p>' . $about['origin_region'] . '</p>';
    }

    $temp = array_chunk($temp, 2);
    //  d($temp);
    ?>

 <div class="tab-pane fade {{ $active_tab == 'about' ? 'show active' : '' }}" id="pills-about" role="tabpanel" aria-labelledby="my-list">
     <div class="row pt-4">
         @if ($temp)
         @foreach ($temp as $k => $val)
         <div class="col-sm-6">
             @foreach ($val as $v)
             <div class="content-detail-about">
                 {!! $v !!}
             </div>
             @endforeach
         </div>
         @endforeach
         @endif

         @if (@$about['cast'])
         <div class="col-sm-12 mt-4">
             <div class="cast">
                {{-- <h6 class="text-white mb-4">{{__('Cast')}}</h6> --}}

                 @foreach ($about['cast'] as $k => $val)
                 <div class="content-detail-about">
                     <h6>{{ $k }}</h6>
                     <p>{{ $val }}</p>
                 </div>
                 @endforeach

                

         </div>
     </div>
     @endif
 </div>
 </div>
 @endif