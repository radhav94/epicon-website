var dummyPlayer;
var is_trailer = false;
var is_episode = false;
var vidPlaying = false;
var cancelStatus = true;
var player;
var cur_cid = null;
var cur_lg = $("#playVideo").data('lg');
var cur_title = $("#playVideo").data('title');
var cur_ctype = null;
var loadPlayerCount = 0;

var intro_start_time = $('.skip-val').attr('start-time');
var intro_end_time = $('.skip-val').attr('end-time');

var content_type_val = $('#content_type_for_next').val();
var countdownDuration = 5;
var lastProgress = 0;
var mov_nexlink = $(".next_movie").attr('next-movie-url');
var mov_neximg = $(".next_movie").attr('next-movie-img');
var mov_title = $(".next_movie").attr('next-movie-title');

let lastTrackedMinuteTime = -1;
let lastPlayTrackTime = 0;

$(document).ready(function () {

	$(document).on('click', '#watchVideo', function () {

		if (vidPlaying && !is_trailer && !is_episode) {
			$('.hide-vid-element').hide();
			window.player.play();
			if (!$('.videoContainer').is(":visible")) {
				$('.videoContainer').show();
			}
			// console.log('video is already playing');
			$('html, body').animate({
				scrollTop: 0
			}, 1000);
			return false;
		}
		is_trailer = false;
		is_episode = false;
		$('#playVideo').trigger('click');

	});

	$(document).on('click', '#playVideo', function () {
		let cid = $(this).data('id');
		let ctype = $(this).data('type');
		let title = $(this).data('title');
		let lg = $(this).data('lg');
		let duration = $(this).data('duration');
		let content_order = $(this).attr('content-order');
		let requestData = {
			cid: cid
		};
		let customData = {
			cid: cid,
			tp: ctype,
			title: title,
			lg: lg,
			duration: duration,
			content_order: content_order
		};

		sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
			onPlayerSuccess, onPlayerError, 'application/json');

		function onPlayerSuccess(response) {
			$('.hide-vid-element').hide();
			// console.log(response);
			// dummyInit = true;

			let video_url;
			if (ctype == 'SHOW' || ctype == 'SEASON') {
				video_url = response.payload.promo_url;
				is_trailer = true;
			} else {
				video_url = response.payload.video_url;
				is_trailer = false;
			}
			// console.log('vid', video_url);

			if (video_url) {
				// if (response.payload.subtitles) {
				// 	$('#vidPlayer').html(response.payload.html);
				// }

				$('.videoContainer').show();
				$('html, body').animate({
					scrollTop: 0
				}, 1000);
				loadVideoPlayer(video_url, response.payload.html, customData);
			}
		}
		function onPlayerError(xhr) {
			$('.hide-vid-element').show();
			try {
				$res = JSON.parse(xhr.responseText);
				if ($res.message != undefined && $res.message != 'failed') {
					// if (dummyPlayer) {
					// 	dummyPlayer.destroy();
					// 	dummyPlayer = new Plyr('#vidPlayer');
					// }
					if ($res.message != 'Content not found') {
						showToaster($res.message, 2);
					} else {
						$('#watchVideo').hide();
					}
				}
			} catch (err) { }
		}
	})


	loadVideoPlayer = function (source, subtitles = '', customData = false) {
		if (player) {
			player.destroy();
		}

		lastTrackedMinuteTime = -1;
		lastPlayTrackTime = 0;

		$('#vidPlayer').html(subtitles);
		// const source = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
		// const source = 'https://epiconvod.s.llnwi.net/mmd-video/lmpl_test/laal-banarasi/season-1/e1-laal-banarasi/stream.ismd/manifest.m3u8?stream=144p;240p;320p;480p;720p;1080p&s=1695536327&e=1696832327&h=6335870e548a7f7dbef3b6244bc52f6e&hls_force_no_caption_tag=true&filter=(type!=\"audio\"||systemBitrate>128000)';

		const video = document.querySelector('video');
		const forwardButton = document.querySelector('.forward-btn');
		const rewindButton = document.querySelector('.rewind-btn');
		const closePlayer = document.getElementById('closePlayer');
		const watchVideo = document.getElementById('watchVideo');
		// const skipButton = document.querySelector('.skip-btn');
		// const customPlayButton = document.getElementById('customPlayButton');
		video.currentTime = parseInt(user_duration);

		let defaultOptions = {
			seekTime: 10,
			controls: ['rewind', 'play', 'fast-forward', 'progress', 'current-time', 'volume', 'mute', 'captions', 'settings', 'pip', 'fullscreen'],
			customData: customData
		};

		// if (subtitles) {
		defaultOptions.captions = { active: true, language: 'auto', update: true, language: 'en' };

		// defaultOptions.captions.tracks = subtitles;
		// }

		if (!Hls.isSupported()) {
			video.src = source;
			player = new Plyr(video, defaultOptions);
			window.player = player;

			attactPlayerEvents(player, customData);

			addCustControls(player);
		} else {
			// For more Hls.js options, see https://github.com/dailymotion/hls.js
			var hls;
			if ($('.live-tv-vidPlayer').length) {
				hls = new Hls();
			} else {
				hls = new Hls({
					xhrSetup: xhr => {
						xhr.setRequestHeader('access', 'allow')
					}
				});
			}

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

				attactPlayerEvents(player, customData);

				addCustControls(player);
			}); //on hls end

			hls.attachMedia(video);
			window.hls = hls;
		}//end if not hls supported


		function addCustControls(player) {

			/* Start Custom Controls */
			const wrapVideoControlRight = document.createElement('div');
			wrapVideoControlRight.classList = 'wrap-div';

			// previous btn bottom left
			const prevEpisode = document.createElement('a');
			prevEpisode.type = 'button';
			prevEpisode.textContent = 'Previous Episode';
			prevEpisode.classList = "epi-prev";

			// Next episode btn bottom right
			const nextEpisode = document.createElement('a');
			nextEpisode.type = 'button';
			nextEpisode.textContent = 'Next Episode';
			nextEpisode.classList = "epi-next";

			// next episode popup start

			// Next episode main div popup
			const nextPopup = document.createElement('div');
			nextPopup.classList.add('nextpopup');

			const nextEpisodeDiv = document.createElement('a');
			nextEpisode.type = 'button';
			nextEpisodeDiv.id = "next-epi-url";
			nextEpisodeDiv.classList = "next-epi-div";

			// Next episode main div popup Next Episode btn
			const nextEpisodeDivBtn = document.createElement("button");
			nextEpisodeDivBtn.textContent = "Next Episode";
			nextEpisodeDivBtn.classList = "next-episode-div-btn";

			// Next episode main div popup Next Episode title
			const nextEpisodeTitleButtonDivWrap = document.createElement("div");
			nextEpisodeTitleButtonDivWrap.classList = "next-episode-title-button-div-wrap";

			const nextEpisodeTitle = document.createElement("h6");
			nextEpisodeTitle.textContent = "Next episode title text";
			nextEpisodeTitle.id = "episod-title";

			const nextEpisodeImg = document.createElement('img');
			nextEpisodeImg.id = "nextimg-src";

			const cancelPopupBtn = document.createElement('a');
			cancelPopupBtn.textContent = 'x';
			cancelPopupBtn.classList.add('cancelepisod');

			const cancelCounter = document.createElement('p');
			cancelCounter.id = 'countdown';

			nextEpisodeDiv.appendChild(nextEpisodeImg, null);
			nextEpisodeDiv.appendChild(nextEpisodeTitleButtonDivWrap, null);

			nextEpisodeTitleButtonDivWrap.appendChild(nextEpisodeTitle, null);
			nextEpisodeTitleButtonDivWrap.appendChild(nextEpisodeDivBtn, null);

			nextEpisodeTitleButtonDivWrap.appendChild(cancelCounter, null);

			nextPopup.appendChild(cancelPopupBtn, null);


			nextPopup.appendChild(nextEpisodeDiv, null);

			// next episode popup end

			// skipp btn 
			const skipButton = document.createElement('div');
			skipButton.textContent = 'Skip Intro';
			skipButton.classList.add('skip-btn');
			//skip intro code

			console.log(player);
			// console.log(window.player);
			// player = window.player;
			player.elements.controls.appendChild(nextPopup);
			// player.elements.controls.appendChild(nextPrevDiv);
			player.elements.controls.appendChild(prevEpisode);
			player.elements.controls.appendChild(nextEpisode);
			player.elements.controls.appendChild(wrapVideoControlRight);
			player.elements.controls.appendChild(skipButton);

			// appending btns controll in wrapVideoControlRight div start
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


			$(".epi-prev").css("display", "none");
			$(".epi-next").css("display", "none");
			//$(".next-prev-div").css("display", "none");
			$(".nextpopup").css("display", "none");

			$(".cancelepisod").click(function () {
				cancelStatus = false;
				$(".nextpopup").css("display", "none");
			});

			// skip intro button
			if (skipButton) {
				skipButton.addEventListener('click', () => {
					player.currentTime = parseInt(intro_end_time);
					$('.skip-btn').css("display", "none");
				});
			}
			// end skip intro button

			if (is_trailer == true && loadPlayerCount == 0) {
				player.muted = true;
			} else {
				player.muted = false;
			}
			player.play();

			loadPlayerCount++;

			player.on('ready', event => {
				$height = $('#vidPlayer').height() + 'px';

				$('#vidPlayer').css({ "object-fit": "cover", "object-position": "center center", "width": "100%", "height": $height });
			});
			/* END Custom Controls */
		}



		if (forwardButton) {
			forwardButton.addEventListener('click', () => {
				player.currentTime += 10;
			});
		}

		if (rewindButton) {
			rewindButton.addEventListener('click', () => {
				player.currentTime -= 10;
			});
		}

		closePlayer.addEventListener('click', () => {
			if (player) {
				player.pause();
			}
			setTimeout(function () {
				$('.nextpopup').css("display", "none");
				$('.next-prev-div').css("display", "none");

			}, 100);
			$('.videoContainer').hide();
			$('.hide-vid-element').show();
		});

		function updateQuality(newQuality) {
			if (newQuality === 0) {
				window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
			} else {
				window.hls.levels.forEach((level, levelIndex) => {
					if (level.height === newQuality) {
						// console.log("Found quality match with " + newQuality);
						window.hls.currentLevel = levelIndex;
					}
				});
			}
		}
	}


	const attactPlayerEvents = function (player, customData) {
		player.on('play', event => {
			vidPlaying = true;
			setplaytracking(player);
			video_play(customData.duration, customData.title);
			if (content_type_val == 'EPISODE') {
				nextwatch();
			}

		});

		player.on('pause', event => {
			var e = Math.round(player.currentTime),
				a = Math.round(player.duration),
				r = parseInt((player.currentTime / player.duration) * 100) + "%",
				o = customData.title;
			setplaytracking(player);
			video_pause(e, a, r, o);

		});

		player.on('seeked', event => {
			setplaytracking(player);
			var e = Math.round(player.currentTime),
				a = Math.round(player.duration),
				o = customData.title;
			r = parseInt((player.currentTime / player.duration) * 100) + "%",
				video_seek(a, e, o, r);

		});

		player.on('ended', event => {
			setplaytracking(player);
			var e = Math.round(player.currentTime),
				a = Math.round(player.duration),
				o = customData.title;
			video_ended(a, e, o);
		});


		var countdownDuration = 5;
		var lastProgress = 0;

		player.on('timeupdate', event => {
			hitPlaytrackingEvery_x_minute(player, 1);
			let duration = Math.round(player.duration);
			let rediduration = Math.round((duration / 100) * 98);
			let currentTime = Math.round(player.currentTime);
			let progress = Math.round(duration - currentTime);

			//skip intro code
			if (intro_start_time != "" && intro_start_time != undefined && intro_end_time != "" && intro_end_time != undefined) {
				if (currentTime >= intro_start_time && currentTime < intro_end_time && is_trailer == false) {
					$(".plyr").removeClass("plyr--hide-controls");
					$(".skip-btn").css("display", "block");
				} else {
					$(".skip-btn").css("display", "none");
					// $(".plyr").addClass("plyr--hide-controls");
				}
			}
			// skip intro code end

			if (!is_trailer && content_type_val == 'VIDEO') {
				if (mov_nexlink != "" && mov_nexlink != undefined) {
					nextMovie(progress, currentTime, rediduration);
				}

			}

			if (content_type_val == 'EPISODE') {
				var plusone = 1;
				var nxtid = (parseInt(customData.content_order) + plusone);
				var nexlink = $("." + nxtid).attr('url-link');
				var neximg = $("." + nxtid).attr('url-img');
				var epstitle = $("." + nxtid).attr('epi-title');
				if (currentTime > rediduration && cancelStatus == true) {
					if (lastProgress != progress && countdownDuration > -1) {
						$('#countdown').text(countdownDuration--);
						lastProgress = progress;
					}
					if (nexlink != "" && nexlink != undefined) {
						$(".plyr").removeClass("plyr--hide-controls");
						$("#nextimg-src").attr('src', neximg);
						$('#next-epi-url').attr('href', nexlink);
						$('#episod-title').text(epstitle);
						$(".nextpopup").css("display", "flex");
						if (countdownDuration == 0) {
							if (cancelStatus == true) {
								console.log("nexlink=" + nexlink);
								window.location.href = nexlink;
								return false;
							}
						}

					}

				} else {
					if (currentTime == duration && nexlink != "" && nexlink != undefined) {
						window.location.href = nexlink;
						return false;
					}
					$(".nextpopup").css("display", "none");
					countdownDuration = 5;
				}
			}
		});
	}

	function nextMovie(progress, currentTime, rediduration) {
		if (currentTime > rediduration && cancelStatus == true) {
			if (lastProgress != progress && countdownDuration > -1) {
				$('#countdown').text(countdownDuration--);
				lastProgress = progress;
			}
			$(".plyr").removeClass("plyr--hide-controls");
			$("#nextimg-src").attr('src', mov_neximg);
			$('#next-epi-url').attr('href', mov_nexlink);
			$('#episod-title').text(mov_title);
			$(".next-episode-div-btn").text('Next Movie');
			$(".nextpopup").css("display", "flex");
			if (countdownDuration == 0) {
				if (cancelStatus == true) {
					console.log("nexlink=" + mov_nexlink);
					window.location.href = mov_nexlink;
					return false;
				}
			}
		} else {
			$(".nextpopup").css("display", "none");
			countdownDuration = 5;
		}
	}

	if (content_type_val == 'EPISODE') {
		nextwatch();
	}


	function nextwatch() {
		var current_order_id = $('#playVideo').attr('content-order');
		var nxtepi = (parseInt(current_order_id) + 1);
		var prvepi = (parseInt(current_order_id) - 1);
		var prevepilink = $("." + prvepi).attr('url-link');
		var nextepilink = $("." + nxtepi).attr('url-link');

		let flag = 0;
		if (nextepilink != "" && nextepilink != undefined) {
			$('.epi-next').attr('href', nextepilink);
			$(".epi-next").css("display", "block");
			flag++;
		} else {
			$(".epi-next").css("display", "none");
		}

		if (prevepilink != "" && prevepilink != undefined) {
			$('.epi-prev').attr('href', prevepilink);
			$(".epi-prev").css("display", "block");
			flag++;
		} else {
			$(".epi-prev").css("display", "none");
		}
		if (flag > 0) {
			$(".next-prev-div").css("display", "flex");
		}
	}

	const setplaytracking = function (player) {
		//player duration is not zero
		if (player.duration < 1) {
			return;
		}
		//player current time and last time api current time hit is not same
		if (player.currentTime == lastPlayTrackTime && lastPlayTrackTime !== 0) {
			return;
		}
		let requestData = player.config.customData;

		if (!requestData) {
			requestData = {
				cid: cur_cid,
				lg: 1,
				tp: cur_ctype,
				title: cur_title,
			};
		}

		requestData.elapsed = player.currentTime;
		requestData.completed = false;

		if ((player.duration - player.currentTime) < 10 && player.duration > 0) {
			requestData.completed = true;
		}

		// if (requestData.lg == 1 ) {
		lastPlayTrackTime = player.currentTime;

		sendAjaxRequest(APP_URL + '/setplayTracking', 'POST', JSON.stringify(requestData),
			onTrackSuccess, onTrackError, 'application/json');

		function onTrackSuccess(response) { }
		function onTrackError(response) { }
		// }
	}

	const hitPlaytrackingEvery_x_minute = function (player, minutes) {
		const currentTime = player.currentTime;
		const timeInMinutes = Math.floor(currentTime / 60);

		// if (timeInMinutes % minutes === 0 && timeInMinutes !== lastTrackedMinuteTime) {
		if (timeInMinutes !== lastTrackedMinuteTime && currentTime >= 1) {
			lastTrackedMinuteTime = timeInMinutes;
			setplaytracking(player);
		}
	}

	if ($("#playVideo").length > 0) {
		$("a, #closePlayer, .switch").click(function () {
			const currentVideo = $('#playVideo').data('id');
			if (currentVideo != "" && typeof player !== "undefined") {
				setplaytracking(player);
			}
		});
	}

	window.addEventListener('beforeunload', function (e) {
		setplaytracking(player);
		// e.preventDefault();
		// e.returnValue = '';
	});
});

function playContentVideo(cid, c_type, element) {

	var promo_url = "";
	var video_url = "";
	cur_cid = cid;
	cur_ctype = c_type;

	if (c_type == 'trailer') {
		is_trailer = true;
		is_episode = false;
	} else if (c_type == 'episode') {
		is_episode = true;
		is_trailer = false;
	}

	let requestData = {
		cid: cid
	};
	sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
		function (response) {
			// console.log(response);

			let playurl;
			if (c_type == 'trailer' && response.payload.promo_url != "") {
				playurl = response.payload.promo_url;
			}
			if (c_type == 'episode' && response.payload.video_url != "") {
				playurl = response.payload.video_url;
			}

			if (playurl) {
				$('.hide-vid-element').hide();
				$('html, body').animate({
					scrollTop: 0
				}, 1000);
				$('.videoContainer').show();
				$('html, body').animate({
					scrollTop: 0
				}, 1000);
				loadVideoPlayer(playurl, response.payload.html);
			}
		},
		function () {

		},
		'application/json'
	);
}


function playTrailer(cid, title, multiPlayUrl) {
	// console.log(multiPlayUrl);
	$('.hide-vid-element').hide();
	$('html, body').animate({
		scrollTop: 0
	}, 1000);
	$('.videoContainer').show();
	$('html, body').animate({
		scrollTop: 0
	}, 1000);

	let lg = $(this).data('lg');

	let customData = {
		cid: cid,
		tp: 'trailer',
		title: title,
		lg: lg
	};
	loadVideoPlayer(multiPlayUrl, '', customData);

}