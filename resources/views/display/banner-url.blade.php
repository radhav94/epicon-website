<div class="banner-url my-4 py-2">
    <div class="container-fluid">
        @php
            $static_banner_img = $value['static_banner_img']['original'] ?? asset('assets/img/default-830x400.png');
        @endphp
        <div class="w-100 text-white pb-0">
            <a href="{{ $value['banner_url'] ??'javascript:void(0);' }}" class="text-decoration-none">
                <img src="{{ $static_banner_img }}" class="w-100" alt="">
            </a>
        </div>
    </div>
</div>