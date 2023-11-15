<section class="container-fluid top-slider addarrow me-0">
    <div class="row me-0 my-2">
        <div class="distro-title heading ps-0">{{ $title }}</div>
    </div>
    <div class="distro-slider mb-4">
    @foreach ($value['content'] as $key => $val)
    <?php //dd($val);  ?>
        <div class="sample_img position-relative me-3">
            <a onclick="click_tile(this)" data-title ="{{ @$val['root_title'] }}" data-type="{{@$title}}" href="{{ getUrl('distro-tv') }}/{{@$val['ID']}}">
                <img src="{{@$val['episodes_img_thumbh']}}" alt="">
            </a>
            <div class="play-button"><img src="{{asset('img/play-white.png')}}" alt=""></div>
        </div>
    @endforeach
    </div>
</section>
  