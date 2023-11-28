var videoPayer;
var customData;
var contentType;

$(document).ready(function () {
    $("#supermixWatchBtn").click(function () {
        let cid = $("#supermixData ul li .supermixPlay").data('id');
        let title = $("#supermixData ul li .supermixPlay").data('title');
        let duration = $("#supermixData ul li .supermixPlay").data('duration');
        $('#supermixData ul li:first-child').addClass('active');
        contentType = 'supermix';
        customData = {
			title: title,
			duration:duration
		};
        getPlayData(cid);
        $(this).prop("disabled", true);
    });

    $(document).on("click", ".supermixPlay", function (e) {
        $("#supermixData ul li").removeClass('active');
        // e.preventDefault();
        $(this).parent('li').addClass('active');
        let cid = $(this).data('id');
        let title;
        let duration;
        title = $(this).data('title');
        duration = $(this).data('duration');
        contentType = 'supermix';
        customData = {
			title: title,
			duration:duration
		};
        getPlayData(cid);
        $('#supermixModal').animate({
            scrollTop: 0
        }, 1000);
        $("#supermixWatchBtn").prop("disabled", true);
    })

    // Add a handler for the modal close event
    $('#supermixModal').on('hidden.bs.modal', function() {
        if (typeof videoPayer !== "undefined") {
            console.log(videoPayer)
            videoPayer.stop();
        }
        $('video').attr('src', '');
    });

    // Add a click event listener to the window
    $(window).click(function(event) {
        // Check if the clicked element is not inside the modal
        if (!$(event.target).closest('#supermixModal').length) {
            $('#supermixModal').modal('hide');
        }
    });
});



function getPlayData(cid) {
    let requestData = {
        cid: cid
    };
    sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
        playerSuccess, playerError, 'application/json');
}

function playerSuccess(response) {
    console.log(JSON.stringify(response));
    let video_url;
    if (contentType == 'SHOW' || contentType == 'SEASON') {
        video_url = response.payload.promo_url;
    } else {
        video_url = response.payload.video_url;
    }
    console.log('vid', video_url);

    if (video_url) {
        $('#supermix-banner-video').show();
        $('#supermix-banner-img').hide();
        loadSupermixVideo(video_url, response.payload.html, customData);
    }
}

function playerError(xhr) {
    try {
        $res = JSON.parse(xhr.responseText);
        if ($res.message != undefined && $res.message != 'failed') {
            if (videoPayer) {
                videoPayer.pause();
                videoPayer.destroy();
            }
            showToaster($res.message, 2);
        }
    } catch (err) { }
}

function loadSupermixVideo(source, subtitles, customData = false) {
    stopPlayer();

    // $('#vidPlayer').html(subtitles);
    // const source = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
    // const source = 'https://epiconvod.s.llnwi.net/mmd-video/lmpl_test/laal-banarasi/season-1/e1-laal-banarasi/stream.ismd/manifest.m3u8?stream=144p;240p;320p;480p;720p;1080p&s=1695536327&e=1696832327&h=6335870e548a7f7dbef3b6244bc52f6e&hls_force_no_caption_tag=true&filter=(type!=\"audio\"||systemBitrate>128000)';

    const video = document.querySelector('video');
    // const forwardButton = document.querySelector('.forward-btn');
    // const rewindButton = document.querySelector('.rewind-btn');
    // const closePlayer = document.getElementById('closePlayer');
    const watchVideo = document.getElementById('watchVideo');
    // const customPlayButton = document.getElementById('customPlayButton');

    const defaultOptions = {
        seekTime: 10,
        controls: ['rewind', 'play', 'fast-forward', 'progress', 'current-time', 'volume', 'captions', 'settings', 'pip', 'fullscreen'],
        customData: customData
    };

    // if (subtitles) {
    defaultOptions.captions = { active: true, language: 'auto', update: true, language: 'en' };

    // defaultOptions.captions.tracks = subtitles;
    // }

    if (!Hls.isSupported()) {
        video.src = source;
        videoPayer = new Plyr(video, defaultOptions);
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
            videoPayer = new Plyr(video, defaultOptions);
            window.player = videoPayer;

            videoPayer.play();
            videoPayer.muted = false;
            videoPayer.on('ended', event => {
                $("#supermixData ul li.active").next('li').find('.supermixPlay').trigger('click');
            });

            attactPlayerEvents(videoPayer);
        });

        hls.attachMedia(video);
        window.hls = hls;


    }

    // forwardButton.addEventListener('click', () => {
    //     player.currentTime += 10;
    // });

    // rewindButton.addEventListener('click', () => {
    //     player.currentTime -= 10;
    // });
    // closePlayer.addEventListener('click', () => {
    //     player.pause();
    //     $('.videoContainer').hide();
    // });


}

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

function stopPlayer() {
    if (videoPayer) {
        videoPayer.pause();
        videoPayer.destroy();
    }
}


const attactPlayerEvents = function (videoPayer) {
    console.log("attactPlayerEvents : "+customData.title);
    player.on('play', event => {
        video_play(customData.duration, customData.title);
    });

    videoPayer.on('pause', event => {
        var e = Math.round(videoPayer.currentTime),
        a = Math.round(videoPayer.duration),
        r = parseInt((videoPayer.currentTime / videoPayer.duration) * 100) + "%";
        o = customData.title;
        video_pause(e, a, r, o);

    });

    videoPayer.on('seeked', event => {
        var e = Math.round(videoPayer.currentTime),
        a = Math.round(videoPayer.duration);
        o = customData.title;
        r = parseInt((videoPayer.currentTime / videoPayer.duration) * 100) + "%";
        video_seek(a, e, o,r);

    });

    videoPayer.on('ended', event => {
        var e = Math.round(videoPayer.currentTime),
        a = Math.round(videoPayer.duration);
        o = customData.title;
        video_ended(a, e, o);
    });

}