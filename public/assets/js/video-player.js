var dummyPlayer;

$(document).ready(function () {
	var vidPlaying = false;
	/*dummyPlayer = new Plyr('#vidPlayer');
	var dummyInit = false;

	dummyPlayer.on('play', () => {
		console.log('Play button clicked!');
		if (dummyInit === false) {
			$('#playVideo').trigger('click');
		}
	});*/

	$(document).on('click', '#watchVideo', function () {
		if (vidPlaying) {

			window.player.play();

			if (!$('.videoContainer').is(":visible")) {
				$('.videoContainer').show();
			}
			console.log('video is already playing');
			$('html, body').animate({
				scrollTop: 0
			}, 1000);
			return false;
		}

		$('#playVideo').trigger('click');
	});

	$(document).on('click', '#playVideo', function () {
		let cid = $(this).data('id');
		let ctype = $(this).data('type');
		let title = $(this).data('title');
		let lg = $(this).data('lg');

		let requestData = {
			cid: cid
		};
		let customData = {
			cid: cid,
			tp: ctype,
			title: title,
			lg: lg
		};

		sendAjaxRequest(APP_URL + '/player', 'POST', JSON.stringify(requestData),
			onPlayerSuccess, onPlayerError, 'application/json');

		function onPlayerSuccess(response) {
			console.log(response);
			// dummyInit = true;

			let video_url;
			if (ctype == 'SHOW' || ctype == 'SEASON') {
				video_url = response.payload.promo_url;
			} else {
				video_url = response.payload.video_url;
			}
			console.log('vid', video_url);

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
			try {
				$res = JSON.parse(xhr.responseText);
				if ($res.message != undefined && $res.message != 'failed') {
					// if (dummyPlayer) {
					// 	dummyPlayer.destroy();
					// 	dummyPlayer = new Plyr('#vidPlayer');
					// }
					showToaster($res.message, 2);
				}
			} catch (err) { }
		}
	})


	const loadVideoPlayer = function (source, subtitles, customData = false) {

		// if (dummyPlayer) {
		// 	dummyPlayer.destroy();
		// }

		$('#vidPlayer').html(subtitles);
		// const source = 'https://bitdash-a.akamaihd.net/content/sintel/hls/playlist.m3u8';
		// const source = 'https://epiconvod.s.llnwi.net/mmd-video/lmpl_test/laal-banarasi/season-1/e1-laal-banarasi/stream.ismd/manifest.m3u8?stream=144p;240p;320p;480p;720p;1080p&s=1695536327&e=1696832327&h=6335870e548a7f7dbef3b6244bc52f6e&hls_force_no_caption_tag=true&filter=(type!=\"audio\"||systemBitrate>128000)';

		const video = document.querySelector('video');
		const forwardButton = document.querySelector('.forward-btn');
		const rewindButton = document.querySelector('.rewind-btn');
		const closePlayer = document.getElementById('closePlayer');
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

		var player;

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

				player.on('ready', event => {
					$height = $('#vidPlayer').height() + 'px';

					$('#vidPlayer').css({ "object-fit": "cover", "object-position": "center center", "width": "100%", "height": $height });

					// Set the desired width and height for the video
					// const videoElement = event.target.elements.container.querySelector('video');

					// console.log('clientWidth', player.elements.wrapper.clientWidth);
					// console.log('config aspectRatio', player.config.video.aspectRatio);


					// const aspectRatio = player.elements.wrapper.clientWidth / player.config.video.aspectRatio;
					// console.log('aspectRatio', aspectRatio);
					// const playerContainer = document.querySelector('.videocont');
					// playerContainer.style.height = `${aspectRatio}px`;

					// videoElement.width = 640;  
					// videoElement.height = 360;  
				});


				// video.style.height = $('#vidPlayer').height() + 'px';

				attactPlayerEvents(player);

				// customPlayButton.style.display = 'none';
			});

			hls.attachMedia(video);
			window.hls = hls;


		}

		forwardButton.addEventListener('click', () => {
			player.currentTime += 10;
		});

		rewindButton.addEventListener('click', () => {
			player.currentTime -= 10;
		});
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

	const attactPlayerEvents = function (player) {
		player.on('play', event => {
			vidPlaying = true;
			setplaytracking(player);
		});

		player.on('pause', event => {
			setplaytracking(player);
		});

		player.on('seeked', event => {
			setplaytracking(player);
		});

		player.on('ended', event => {
			setplaytracking(player);
		});

	}

	const setplaytracking = function (player) {

		let requestData = player.config.customData;
		requestData.elapsed = player.currentTime;
		requestData.completed = false;

		if ((player.duration - player.currentTime) < 10) {
			requestData.completed = true;
		}

		if (requestData.lg == 1) {
			sendAjaxRequest(APP_URL + '/setplayTracking', 'POST', JSON.stringify(requestData),
				onTrackSuccess, onTrackError, 'application/json');

			function onTrackSuccess(response) { }
			function onTrackError(response) { }
		}
	}

	/*
		// Calculate the height based on the aspect ratio and container width
		function setPlayerHeight() {
			const aspectRatio = player.elements.wrapper.clientWidth / player.config.video.aspectRatio;
			const playerContainer = document.querySelector('.videocont');
			playerContainer.style.height = `${aspectRatio}px`;
		}
	
		// Set the player height initially
		setPlayerHeight();
	
		// Update the player height when the window is resized
		window.addEventListener('resize', setPlayerHeight);
		*/
});