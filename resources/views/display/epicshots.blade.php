<section class="carousel-main mt-0" id="epic-shots">
    <div class="carousel-title-n-arrow px-2 pb-3">
        <h1 class="text-white small">{{$title}}</h1>
        <a href="">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <path d="M14.0533 11.2933L18.7466 16L14.0533 20.7067" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <div class="gaming-galore-main">
        <div class="epic-shots">
            @foreach ($stories as $story)
            <div>
                <a href="javascript:void(0)" class="storyBtn" data-id="{{$story['id']}}">
                    <img src="{{$story['img_url']}}" alt="shots">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    #epicShots .plyr__controls__item, #epicShots .plyr__progress__buffer {
        display: none;
    }

</style>

<!-- Epic Shots model -->
<div class="modal epic-shots-modal fade" id="epicShots" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-0">
            <!-- story content coming from ajax -->
        </div>
    </div>
</div>