@if($contents)
<ul>
    @foreach($contents as $key => $value)
    <li class="d-flex distro-s-li" data-url="{{ getUrl('distro-tv') }}/{{@$value['id']}}">
        <div class="distro-search-img"><img src="{{@$value['episodes_img_thumbh']}}" alt="icon"></div>
        <div class="distro-search-title-text">
            <h1 class="distro-search-title">{{ @$value['root_title'] }}</h1>
            <p class="distro-search-text">{{ @$value['root_description'] }}</p>
        </div>
    </li>
    @endforeach
</ul>
@else
<p class="distro-no-res">No results found</p>
@endif