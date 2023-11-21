<section class="container-fluid px-2">
    <div class="genere-fiesta">
        <div class="genere-fiesta-title">
            <h1>{{ $title }}</h1>

            @if (@$value['show_more'])
                <a href="{{ getMidPageUrl($value) }}">
                    <button>Explore More
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                            fill="none">
                            <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </a>
            @endif


        </div>
        <div class="genere-fiesta-content">
            <div>
                @foreach ($value['content'] as $key => $val)
                    <?php
                    $card = getItemCardData($val, $displayLanguageParam);
                    ?>
                    <a href="{{ url('explore/' . @$val['slug']) }}">
                        <button>
                            <img src="{{ $val['fiesta_image'] ?? '' }}">
                            {{ $val['name'] }}
                        </button>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
</section>
