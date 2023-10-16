let currentStep = 1;
var player;

$(document).ready(function () {
    $(".storyBtn").click(function () {
        var storyId = $(this).data('id');
        $.ajax({
            async: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/ajaxStoryData',
            data: {
                id: storyId
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.payload.html != '') {
                    $('#epicShots .modal-content').html(response.payload.html);
                    currentStep = 1;
                    $(".progressBar progress:nth-child(" + currentStep + ")").val(100);
                    showStoryPopup(currentStep);
                } else {
                    $('.loadmorecontent').css('overflow', 'auto');
                    return false;
                }
            }
        });
    })
    if (player) {
        player.muted = false;
    }
})

$(document).on('click', ".mute-btn-storie", function () {
    console.log(player.muted);
    if (player) {
        console.log(player.muted);
        if (player.muted) {
            player.muted = false;
        } else {
            player.muted = true;
        }
    }
})

$(document).on('click', '.nextStoryBtn', function () {
    if (currentStep < $(".story-modal").length) {
        currentStep++;
        showStoryPopup(currentStep);
        $(".progressBar progress:nth-child(" + currentStep + ")").val(100);
    }
});

$(document).on('click', '.previousStoryBtn', function () {
    if (currentStep > 1) {
        $(".progressBar progress:nth-child(" + currentStep + ")").val(0);
        currentStep--;
        showStoryPopup(currentStep);
    }
});

$(document).on('click', '.epic-short-close', function () {
    if (player) {
        player.pause();
        player.destroy();
    }
    $(".modal").modal('hide');
    $('#epicShots .modal-content').html("");
});

$(document).on('click', '.story-play-btn', function (e) {
    e.preventDefault();
    let cid = $(this).data('id');

    let requestData = {
        cid: cid
    };
    let customData = false;

    sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
        onPlayerSuccess, onPlayerError, 'application/json');

    function onPlayerSuccess(response) {
        console.log(response);

        let video_url = response.payload.promo_url != "" ? response.payload.promo_url : response.payload.video_url;
        console.log('vid', video_url);

        if (video_url) {
            loadStoryVideoPlayer(video_url, response.payload.html, customData);
        }
    }

    function onPlayerError(xhr) {
        try {
            $res = JSON.parse(xhr.responseText);
            if ($res.message != undefined && $res.message != 'failed') {
                showToaster($res.message, 2);
            }
        } catch (err) { }
    }

    const loadStoryVideoPlayer = function (source, subtitles, customData = false) {

        if (player) {
            player.pause();
            player.destroy();
        }

        const video = document.querySelector("#story-modal-" + currentStep + " video");
        const closePlayer = document.querySelector(".epic-short-close");
        const customPlayButton = document.querySelector('.story-play-btn');
        
        const defaultOptions = {
            seekTime: 10,
            controls: ['rewind', 'play', 'fast-forward', 'progress', 'current-time', 'volume', 'captions', 'settings', 'pip'],
            customData: customData
        };

        if (subtitles) {
            defaultOptions.captions = { active: true, language: 'auto', update: true, language: 'en' };
            defaultOptions.captions.tracks = subtitles;
        }

        if (!Hls.isSupported()) {
            video.src = source;
            player = new Plyr(video, defaultOptions);
        } else {
            // For more Hls.js options, see https://github.com/dailymotion/hls.js
            const hls = new Hls();
            hls.loadSource(source);

            // From the m3u8 playlist, hls parses the manifest and returns
            // all available video qualities. This is important, in this approach,
            // we will have one source on the Plyr player.
            hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

                // Transform available levels into an array of integers (height values).
                const availableQualities = hls.levels.map((l) => l.height)
                availableQualities.unshift(0) //prepend 0 to quality array

                // Add new qualities to option
                defaultOptions.quality = {
                    default: 0, //Default - AUTO
                    options: availableQualities,
                    forced: true,
                    onChange: (e) => updateQuality(e),
                }
                // Add Auto Label 
                defaultOptions.i18n = {
                    qualityLabel: {
                        0: 'Auto',
                    },
                }

                hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {
                    var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
                    if (hls.autoLevelEnabled) {
                        span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
                    } else {
                        span.innerHTML = `AUTO`
                    }
                })

                // Initialize new Plyr player with quality options
                player = new Plyr(video, defaultOptions);
                window.player = player;

                player.play();
                attactPlayerEvents(player);
            });

            hls.attachMedia(video);
            window.hls = hls;
        }

        closePlayer.addEventListener('click', () => {
            player.pause();
            $('.videoContainer').hide();
        });

        function updateQuality(newQuality) {
            if (newQuality === 0) {
                window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
            } else {
                window.hls.levels.forEach((level, levelIndex) => {
                    if (level.height === newQuality) {
                        console.log("Found quality match with " + newQuality);
                        window.hls.currentLevel = levelIndex;
                    }
                });
            }
        }
    }
});

function showStoryPopup(step) {
    $(".story-modal").hide();
    $("#story-modal-" + step).show();
    if (step == 1) {
        $(".previousStoryBtn").hide();
    } else {
        $(".previousStoryBtn").show();
    }

    if (step == $(".story-modal").length) {
        $(".nextStoryBtn").hide();
    } else {
        $(".nextStoryBtn").show();
    }
    playnextcontent();
}

function playnextcontent() {
    if (player) {
        player.pause();
        player.destroy();
    }
    $("#story-modal-" + currentStep + " .story-play-btn").trigger('click');
}