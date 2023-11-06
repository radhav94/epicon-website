var dt = 0;
function datalayers() {
    var e = $("#page_title").data("page-title");
    dataLayer.push({ client_ga_id: "308089989", content_type: e, platform_type: "web", environment: "develop" });
}
function time_on_page() {
    var e = new Date(),
        a = Math.abs(dt.getTime() - e.getTime());
    return Math.ceil(a / 1e3);
}
function click_social(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("title"),
        t = $(e).data("event_context");
    dataLayer.push({ event: "click_social", element_text: a, event_context: t, time_on_page: time_on_page() });
}
function click_carousel(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("title");
    alert(a);
    dataLayer.push({ event: "click_carousel", element_text: a, time_on_page: time_on_page() });
}
function share(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("title"),
        t = $(e).data("type"),
        n = $(e).data("method");
    dataLayer.push({ event: "share", content_name: a, content_type: t, share_method: n, time_on_page: time_on_page() });
}
function click_tile(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("title"),
        t = $(e).data("type");
        alert(a);
        alert(t);
    dataLayer.push({ event: "click_tile", content_name: a, event_context: t, time_on_page: time_on_page() });
}
function click_teams(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("event_context"),
        t = $(e).data("team_name"),
        n = $(e).data("player_name");
    dataLayer.push({ event: "click_teams", event_context: a, team_name: t, player_name: n, time_on_page: time_on_page() });
}
function outbound_click(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("event_context"),
        t = $(e).data("element_text");
    dataLayer.push({ event: "outbound_click", event_context: a, element_text: t, time_on_page: time_on_page() });
}
function searchEvent(e) {
    if ($("#searchInputForHeader").val().trim()) {
        window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
        var a = $("#content_type option:selected").val(),
            t = $("#searchInputForHeader").val().trim();
        dataLayer.push({ event: "search", search_type: a, search_term: t.toLowerCase() });
    }
}
function click_search_results(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $("#content_type option:selected").val(),
        t = $("#searchInputForHeader").val(),
        n = $(e).data("element_text");
    dataLayer.push({ event: "click_search_results", search_type: a, search_term: t, element_text: n, time_on_page: time_on_page() });
}
function click_menu(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("event_context"),
        t = $(e).data("element_text");
    dataLayer.push({ event: "click_menu", event_context: a, element_text: t, time_on_page: time_on_page() }), window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset();
}
function video_start(e, a) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_start", video_duration: e, video_name: a });
}
function video_pause(e, a, t, n) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_pause", video_duration: a, video_name: n, video_percent_viewed: t, video_seconds_viewed: e });
}
function video_complete(e, a, t) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers(), dataLayer.push({ event: "video_complete", video_duration: a, video_name: t, video_seconds_viewed: e });
}
function click_cta(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("event_context"),
        t = $(e).data("element_text");
        alert(a);
    dataLayer.push({ event: "click_cta", event_context: a, element_text: t, time_on_page: time_on_page() });
}
function click_player(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("player_name");
    dataLayer.push({ event: "click_player", player_name: a, time_on_page: time_on_page() });
}
function file_download(e) {
    window.google_tag_manager["G-8JER642T3Z"].dataLayer.reset(), datalayers();
    var a = $(e).data("file_name"),
        t = $(e).data("file_type");
    dataLayer.push({ event: "file_download", file_name: a, file_type: t });
}
$(document).ready(function () {
    dt = new Date();
});
