var storedDeviceId = localStorage.getItem('deviceId');

function eventAfterDistroLoad() {
	// Generate a random UUIDv4 string
	var uuid = generateUUIDv4();
	var r = Math.random(); //<random>
	var e = 'ff'; //<event_name>
	var u = storedDeviceId; //<device_or_adver/sing_id>
	var i = uuid; //<dai_session_id>
	var v = uuid; //<dai_session_id>
	var f = 'distro-tv'; //<dai_asset_key>
	var m = 'Epicon'; //<appname>
	var p = ''; //<content_provider_id>
	var show = ''; //<show_id>
	var ep = ''; //<episode_id>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "https://i.jsrdn.com/i/1.gif?",
		data: { r: r, e: e, u: u, i: i, v: v, f: f, m: m, p: p, show: show, ep: ep },
		dataType: 'jsonp',
		cors: true,
		contentType: 'application/json',
		secure: true,
		headers: {
			'Access-Control-Allow-Origin': '*',
		},
		type: "GET",
		cache: false,
	});
}

function generateUUIDv4() {
	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
		var r = Math.random() * 16 | 0,
			v = c == 'x' ? r : (r & 0x3 | 0x8);
		return v.toString(16);
	});
}

function distroPlay() {
	TrackVideo();
	var storedDeviceId = localStorage.getItem('deviceId');
	// Generate a random UUIDv4 string
	var uuid = generateUUIDv4();
	var r = Math.random(); //<random>
	var e = 'vplay'; //<event_name>
	var u = storedDeviceId; //<device_or_adver/sing_id>
	var i = uuid; //<dai_session_id>
	var v = uuid; //<dai_session_id>
	var f = $('#dai_session_id').val(); //<dai_asset_key>
	var m = 'Epicon'; //<appname>
	var p = $('#content_provider').val(); //<content_provider_id>
	var show = $('#show_id').val(); //<show_id>
	var ep = $('#episode_id').val(); //<episode_id>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url: "https://i.jsrdn.com/i/1.gif?",
		data: { r: r, e: e, u: u, i: i, v: v, f: f, m: m, p: p, show: show, ep: ep },
		dataType: 'jsonp',
		cors: true,
		contentType: 'application/json',
		secure: true,
		headers: {
			'Access-Control-Allow-Origin': '*',
		},
		type: "GET",
		cache: false,
	});
}


function TrackVideo() {
	// Define the base URL
	var baseUrl = 'https://i.jsrdn.com/i/1.gif';
	// Array of 'e' values
	var eValues = ['vs1', 'vs2', 'vs3', 'vs4', 'vs5', 'vs6', 'vs7', 'vs8', 'vs9', 'vs10'];

	var currentIndex = 0;
	// Function to make the request with a random 'e' value
	function makeRequest() {
		// Check if we've reached the end of the array
		if (currentIndex >= eValues.length) {
			// Stop executing when we reach 'vs10'
			clearInterval(intervalId);
			// console.log('Reached vs10. Stopping execution.');
			return;
		}
		var storedDeviceId = localStorage.getItem('deviceId');
		// Generate a random UUIDv4 string
		var uuid = generateUUIDv4();
		// Pick a random 'e' value from the array
		// var randomE = eValues[Math.floor(Math.random() * eValues.length)];
		var r = Math.random(); //<random>
		var e = eValues[currentIndex]; //<event_name>
		var u = storedDeviceId; //<device_or_adver/sing_id>
		var i = uuid; //<dai_session_id>
		var v = uuid; //<dai_session_id>
		var f = $('#dai_session_id').val(); //<dai_asset_key>
		var m = 'Epicon'; //<appname>
		var p = $('#content_provider').val(); //<content_provider_id>
		var show = $('#show_id').val(); //<show_id>
		var ep = $('#episode_id').val(); //<episode_id>

		// Build the complete URL with the random 'e' value
		var url = baseUrl + '?';

		// Make the HTTP request using jQuery's AJAX
		$.ajax({
			url: url,
			data: { r: r, e: e, u: u, i: i, v: v, f: f, m: m, p: p, show: show, ep: ep },
			dataType: 'jsonp', // Use 'jsonp' if needed to bypass cross-origin issues
			success: function (response) {
				// Handle the response if needed
				// console.log('Request successful for e=' + currentE);
			}
		});
		// Increment the index for the next 'e' value
		currentIndex++;
	}

	// Call the makeRequest function every second
	var intervalId = setInterval(makeRequest, 1000);
}





