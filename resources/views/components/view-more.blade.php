@if (@$value['show_more'])
            @if(@$value['is_hybrid'])
            <form method="post" action="{{ getMidPageUrl($value) }}">
            @csrf
            <input type="hidden" name ="is_hybrid" value="{{@$value['is_hybrid']}}">
            <input type="hidden" name ="genre_viewall" value="{{implode(",", $value['genre_viewall'])}}">
            <input type="hidden" name ="catalog_viewall" value="{{implode(",", $value['catalog_viewall'])}}">
            <input type="hidden" name ="list_language_viewall" value="{{implode(",", $value['list_language_viewall'])}}">
            <button type="submit">
                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                     <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
            </button>
             </form>
             @else
             <a href="{{ getMidPageUrl($value) }}">
                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                     <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
             </a>
             @endif
         @endif