 <?php
 $wishlist = getWishlist();
 ?>

 @if (@$result['data']['list'])
     @foreach ($result['data']['list'] as $key => $value)
         @if (isset($value['display_type']) && isset($value['content']) && !empty($value['content']))
             @php
                 $template = 'display.' . $value['display_type'];
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
                     'shortdescription' => $shortdescription,
                 ])

                @if (isset($stories) && @$value['slug'] == "uniquely-yours")
                    @include('display.epicshots', ['stories' => $stories])
                @endif
             @else
                 <h1>
                     Template not found - {{ $value['display_type'] }}
                 </h1>
             @endif
         @endif
     @endforeach
 @endif
