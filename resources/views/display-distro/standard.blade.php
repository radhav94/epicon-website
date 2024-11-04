<section class="container-fluid top-slider addarrow me-0">
    <div class="row">
        <div class="distro-title heading">{{ $title }}</div>
    </div>
    <div class="distro-slider mb-4">
    @foreach ($value['content'] as $key => $val)
     {{-- @dd($val) --}}
        <div class="sample_img position-relative me-3">
            <a onclick="click_tile(this)" data-title ="{{ @$val['root_title'] }}" data-type="{{@$title}}" href="{{ getUrl('distro-tv') }}/{{@$val['ID']}}">
                <img src="{{@$val['episodes_img_thumbh']}}" alt="">
            </a>
            <div class="play-button"><img src="{{env('AWS_S3_domain')}}epicon/assets/images/play-white.png" alt=""></div>
        </div>
    @endforeach
    </div>
</section>
  