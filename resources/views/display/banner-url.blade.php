<div class="banner-url my-4">
    <div class="container-fluid">
        @php
            $newtab = '';
            $static_banner_img = !empty($value['web_static_banner_img']['original'] ?? '')
                ? $value['web_static_banner_img']['original']
                : $value['static_banner_img']['original'] ?? env('AWS_S3_domain').'epicon/assets/images/default-830x400.png';
            $gameUrl = $value['banner_url'] ?? 'javascript:void(0);';
            $subplan = checkSubscription();
        @endphp
        @if (@$value['slug'] == 'rumble-game')
            @if (@$subplan['status'] == 'active')
                @php
                    $newtab = 'target=_blank';
                    $gameUrl = $value['banner_url'] ?? 'javascript:void(0);';
                @endphp
            @else
                @php
                    $newtab = '';
                    $gameUrl = url('subscription');
                @endphp
            @endif
        @endif

        <div class="w-100 text-white pb-0">
            <a onclick="click_tile(this)" data-title ="{{ @$value['title'] }}" data-type="{{ @$title }}"
                href="{{ $gameUrl }}" class="single-banner" {{ $newtab }} aria-label="{{ @$value['title'] }}">
                <img src="{{ $static_banner_img }}" alt="{{ @$value['title'] }}" width="1602" height="502">
            </a>
        </div>
    </div>
</div>
