var dt = 0;
$(document).ready(function () {
    dt = new Date();
});
function datalayers() {
    try {
        var e = $("#page_title").data("page-title");
        dataLayer.push({ client_ga_id: "374718823", content_type: e, platform_type: "web", environment: "develop" });
    } catch (error) {
    }

}
function time_on_page() {
    var e = new Date(),
        a = Math.abs(dt.getTime() - e.getTime());
    return Math.ceil(a / 1e3);
}
function click_social(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("title"),
            t = $(e).data("event_context");
        dataLayer.push({ event: "click_social", element_text: a, event_context: t, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_subscription() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var plan_name = $('.planid.active h6 p').text();
        var plan_price = $('.planid.active h3').text();
        dataLayer.push({ event: "click_subscription", element_text: plan_name.replace(/\s+/g, ' '), event_context: plan_price.replace(/\s+/g, ' '), time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_carousel(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("title");
        dataLayer.push({ event: "click_carousel", element_text: a, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function share(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("title"),
            t = $(e).data("type"),
            n = $(e).data("method");
        dataLayer.push({ event: "share", content_name: a, content_type: t, share_method: n, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_tile(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("title"),
            t = $(e).data("type");
        dataLayer.push({ event: "click_tile", content_name: a, event_context: t, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_explore(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("title"),
            t = "explore";
        dataLayer.push({ event: "click_explore", content_name: a, event_context: t, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_teams(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("event_context"),
            t = $(e).data("team_name"),
            n = $(e).data("player_name");
        dataLayer.push({ event: "click_teams", event_context: a, team_name: t, player_name: n, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function outbound_click(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("event_context"),
            t = $(e).data("element_text");
        dataLayer.push({ event: "outbound_click", event_context: a, element_text: t, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function searchEvent(e) {
    if ($('input[name="search"]').val().trim()) {
        try {
            window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
            var t = $('input[name="search"]').val().trim();
            dataLayer.push({ event: "search", search_term: t.toLowerCase() });
        } catch (error) {

        }
    }
}
function click_search_results(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var t = $('input[name="search"]').val(),
            n = $(e).data("element_text");
        dataLayer.push({ event: "click_search_results", search_term: t, element_text: n, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_menu(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        window.dataLayer = window.dataLayer || [];
        var a = $(e).data("event_context"),
            t = $(e).data("element_text");
        window.dataLayer.push({ event: "click_menu", event_context: a, element_text: t, time_on_page: time_on_page() }), window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
    } catch (error) {

    }
}

function click_spinner(a) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "click_spinner", element_text: a });
    } catch (error) {

    }
}

function video_play(e, a) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_start", video_duration: e, video_name: a });
    } catch (error) {

    }
}
function video_pause(e, a, t, n) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_pause", video_duration: a, video_name: n, video_percent_viewed: t, video_seconds_viewed: e });
    } catch (error) {

    }
}
function video_seek(a, e, o, i) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_progress", video_duration: a, video_name: o, video_seconds_viewed: e, video_percent_viewed: i });
    } catch (error) {

    }
}
function video_ended(a, e, o) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_complete", video_duration: a, video_name: o, video_seconds_viewed: e });
    } catch (error) {

    }
}
function audio_play(e, a) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "audio_start", audio_duration: e, audio_name: a });
    } catch (error) {

    }
}
function audio_pause(e, a, t, n) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "audio_pause", audio_duration: e, audio_name: a, audio_percent_viewed: t, audio_seconds_viewed: n });
    } catch (error) {
    }
}
function audio_seek(a, e, o, i) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "audio_progress", audio_duration: a, audio_name: e, audio_seconds_viewed: o, audio_percent_viewed: i });

    } catch (error) {

    }
}
function audio_ended(a, e, o) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "audio_complete", audio_duration: a, audio_name: e, audio_seconds_viewed: o });
    } catch (error) {

    }
}

function click_cta(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("event_context"),
            t = $(e).data("element_text");
        dataLayer.push({ event: "click_cta", event_context: a, element_text: t, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function click_player(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("player_name");
        dataLayer.push({ event: "click_player", player_name: a, time_on_page: time_on_page() });
    } catch (error) {

    }
}
function file_download(e) {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $(e).data("file_name"),
            t = $(e).data("file_type");
        dataLayer.push({ event: "file_download", file_name: a, file_type: t });
    } catch (error) {

    }
}

function login_start() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "login_start" });
    } catch (error) {

    }
}
function login_success() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "login_success" });
    } catch (error) {

    }
}
function login_failed() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "login_failed" });
    } catch (error) {

    }
}
function login_skip() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "login_skip" });
    } catch (error) {

    }
}

function registration_start() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "registration_start" });
    } catch (error) {

    }
}
function registration_success() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "registration_success" });
    } catch (error) {

    }
}
function registration_failed() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "registration_failed" });
    } catch (error) {

    }
}
function registration_skip() {
    try {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        dataLayer.push({ event: "registration_skip" });
    } catch (error) {

    }
}
$(document).ready(function () {
    dt = new Date();
});
