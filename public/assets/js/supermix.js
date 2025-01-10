var videoPayer;
var customData;
var contentType;

$(document).ready(function () {
    $(document).on("click", "#supermixWatchBtn", function () {
        let cid = $("#supermixData ul li .supermixPlay").data('id');
        let title = $("#supermixData ul li .supermixPlay").data('title');
        let duration = $("#supermixData ul li .supermixPlay").data('duration');
        $('#supermixData ul li:first-child').addClass('active');
        contentType = 'supermix';
        customData = {
            title: title,
            duration: duration
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
            duration: duration
        };
        getPlayData(cid);
        $('#supermixModal').animate({
            scrollTop: 0
        }, 1000);
        $("#supermixWatchBtn").prop("disabled", true);
    })

    // Add a handler for the modal close event
    $('#supermixModal').on('hidden.bs.modal', function () {
        if (typeof videoPayer !== "undefined") {
            videoPayer.stop();
        }
        $('video').attr('src', '');
    });

    // Add a click event listener to the window
    $(window).click(function (event) {
        // Check if the clicked element is not inside the modal
        if (!$(event.target).closest('#supermixModal').length) {
            $('#supermixModal').modal('hide');
            if (typeof videoPayer !== "undefined") {
                videoPayer.stop();
            }
        }
    });


    function getPlayData(cid) {
        let requestData = {
            cid: cid
        };
        sendAjaxRequest(APP_URL + '/player?cid='+cid, 'GET', null,
            playerSuccess, playerError, 'application/json');
    }

    function playerSuccess(response) {

        let video_url;
        if (contentType == 'SHOW' || contentType == 'SEASON') {
            video_url = response.payload.promo_url;
        } else {
            video_url = response.payload.video_url;
        }


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

    const attactPlayerEvents = function (videoPayer) {

        videoPayer.on('play', event => {
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
            video_seek(a, e, o, r);

        });

        videoPayer.on('ended', event => {
            var e = Math.round(videoPayer.currentTime),
                a = Math.round(videoPayer.duration);
            o = customData.title;
            video_ended(a, e, o);
        });

    }

    function addMixCustControls(player) {

        /* Start Custom Controls */
        const wrapVideoControlRight = document.createElement('div');
        wrapVideoControlRight.classList = 'wrap-div';


        // player = window.player;
        player.elements.controls.appendChild(wrapVideoControlRight);


        const captn = document.querySelector('[data-plyr="captions"]');
        if (captn) {
            captn.classList.add("caption");
            captn.classList.remove("plyr__controls__item");
            wrapVideoControlRight.appendChild(captn, null);
        }

        const muteBtn = document.querySelector('[data-plyr="mute"]');
        if (muteBtn) {
            muteBtn.classList.add("mute");
            muteBtn.classList.remove('plyr__controls__item');
            wrapVideoControlRight.appendChild(muteBtn, null);
        }

        const pipp = document.querySelector('[data-plyr="pip"]');
        if (pipp) {
            pipp.classList.add("pipmod");
            pipp.classList.remove('plyr__controls__item');
            wrapVideoControlRight.appendChild(pipp, null);
        }

        const plyrMenuSpeed = document.querySelector('.plyr__menu');
        if (plyrMenuSpeed) {
            plyrMenuSpeed.classList.remove('plyr__controls__item');
            wrapVideoControlRight.appendChild(plyrMenuSpeed, null);
        }

        const fullscreen = document.querySelector('[data-plyr="fullscreen"]');
        if (fullscreen) {
            fullscreen.classList.add("fullscreen");
            fullscreen.classList.remove("plyr__controls__item");
            wrapVideoControlRight.appendChild(fullscreen, null);
        }

        // wrapVideoControlRight.appendChild(nextEpisode, null);

        // appending btns controll in wrapVideoControlRight div end
        const playerMenuFisrtChild = document.querySelector('.plyr__menu').firstChild;
        playerMenuFisrtChild.classList.add("setting-first-btn");
        // alert(playerMenuFisrtChild);

        // player.play();
        /* END Custom Controls */
    }

    function loadSupermixVideo(source, subtitles, customData = false) {
        stopPlayer();

        const video = document.querySelector('#supermix-banner-video video');
        const watchVideo = document.getElementById('watchVideo');

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
            attactPlayerEvents(videoPayer);

            // addMixCustControls(videoPayer);
        } else {
            const hls = new Hls();
            hls.loadSource(source);

            hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

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

                // addMixCustControls(videoPayer);

            });

            hls.attachMedia(video);
            window.hls = hls;
        }
    }

    function updateQuality(newQuality) {
        if (newQuality === 0) {
            window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
        } else {
            window.hls.levels.forEach((level, levelIndex) => {
                if (level.height === newQuality) {

                    window.hls.currentLevel = levelIndex;
                }
            });
        }
    }

  

});

function stopPlayer() {
    if (videoPayer) {
        videoPayer.pause();
        videoPayer.destroy();
    }
}