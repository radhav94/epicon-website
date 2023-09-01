<section class="carousel-main px-2">
    <div class="genere-fiesta">
        <div class="genere-fiesta-title">
            <h1>{{ $title }}</h1>

            @if (@$value['show_more'])
                <a href="{{ url($value['slug'] ?? '/') }}">
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
                    <button>
                        <img src="{{ $card['banner_img'] }}">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="1.5" y="6" width="19.5" height="3" fill="#FFB0B0" />
                        <path d="M22 3.99716C22 3.44457 21.5542 3 21 3C20.4458 3 20 3.44457 20 3.99716V4.32955H1.33333C0.595833 4.32955 0 4.92369 0 5.65909V10.3125C0 11.0479 0.595833 11.642 1.33333 11.642H1.75C2.61667 11.642 3.25417 12.4564 3.04167 13.2957L1.375 19.96C1.275 20.3589 1.36667 20.7785 1.61667 21.1026C1.86667 21.4267 2.25417 21.6136 2.66667 21.6136H6.66667C7.27917 21.6136 7.8125 21.1982 7.95833 20.6082L9.04167 16.2955H13.3917C14.3792 16.2955 15.2583 15.6764 15.5875 14.7499L16.7042 11.642H18C18.3542 11.642 18.6917 11.5008 18.9417 11.2515L19.8875 10.3125H22.6667C23.4042 10.3125 24 9.71836 24 8.98295V5.65909C24 4.92369 23.4042 4.32955 22.6667 4.32955H22V3.99716ZM13.3917 14.3011H9.54167L10.2083 11.642H14.5833L13.7083 14.0809C13.6625 14.2139 13.5333 14.3011 13.3958 14.3011H13.3917ZM3.33333 6.98864H19.3333C19.7 6.98864 20 7.28778 20 7.65341C20 8.01903 19.7 8.31818 19.3333 8.31818H3.33333C2.96667 8.31818 2.66667 8.01903 2.66667 7.65341C2.66667 7.28778 2.96667 6.98864 3.33333 6.98864Z" fill="#FF4444" />
                    </svg> -->
                        {{ $val['name'] }}
                    </button>
                @endforeach

            </div>
        </div>
    </div>
</section>
