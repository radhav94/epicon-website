 <?php
 $wishlist = getWishlist();
 ?>

 @if (@$result['data']['list'])
     @foreach ($result['data']['list'] as $key => $value)
         @if (isset($value['display_type']) && ((isset($value['content']) && !empty($value['content'])) || $value['display_type'] == "shortandsweet" || $value['display_type'] == "supermix" || $value['display_type'] == "banner-url" || $value['display_type'] == "banner-kid"))
             @php
                 $template = 'display.' . $value['display_type'];
             @endphp

             @if ($value['display_type'] == 'supermix')
                 @include('components.supermix-content-modal')
             @endif

             @if (View::exists($template))
                 <?php
                 $title = getDispLangContent($value, $displayLanguageParam, 'title');
                 $shortdescription = getDispLangContent($value, $displayLanguageParam, 'shortdesc');
                 
                 ?>

                 @if (request()->get('v'))
                     <h1>{{ $value['display_type'] }}</h1>
                 @endif

                @if (isset($stories) && $value['display_type'] == "shortandsweet")
                    @include('display.epicshots', ['stories' => $stories])
                    @include('components.video-player-modal')
                @else
                    @include($template, [
                        'value' => $value,
                        'title' => $title,
                        'shortdescription' => sanitizeData($shortdescription),
                    ])
                @endif
             @else
                {{--
                 <h1>
                     Template not found - {{ $value['display_type'] }}
                 </h1>--}}
             @endif
         @endif
     @endforeach
 @endif
