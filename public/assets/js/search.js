
$(document).ready(function () {
    $("#searchname").on("keyup", function () {
        $("#searchTab, #noData-error").hide();
        $('.otherResult .topResult').html('');
        var searchtext = $('input[name="search"]').val();
        if (searchtext != "") {
            $(".remove-text").show();
        } else {
            $(".remove-text, .Alltopresult-error").hide();
            $('#Alltopresult, #Moviestopresult, #Showtopresult, #Podcasttopresult, #Kidstopresult, #Gamestopresult').html("");
        }
        console.log(searchtext + " Text Value");
        var lang = $("html").attr("lang") != 'en' ? $("html").attr("lang") + "/" : "";
        var ajaxUrl = lang + 'get-search';
        if (searchtext.length > 2) {
            searchEvent();
            $.ajax({
                url: "/" + ajaxUrl,
                type: 'GET',
                data: { 'searchinput': searchtext },
                dataType: 'json',
                async: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var response = data.payload.data;

                    if (data.payload.success) {
                        $("#search-result").hide();
                        var result = false;
                        var topResult = response.topResult;
                        var otherResult = response.otherResult;
                        // console.log(topResult);

                        if (topResult) {
                            Object.keys(topResult).forEach(function (key) {
                                $('#' + key + 'Top').html(topResult[key]);
                            });
                        } else {
                            $('.topResult').html('');
                        }

                        if (otherResult) {
                            Object.keys(otherResult).forEach(function (key) {
                                if (otherResult[key] !== "") {
                                    result = true;
                                    $('#' + key + 'Other').html(otherResult[key]);
                                }
                            });
                        } else {
                            $('.otherResult').html('');
                        }

                        var showHide = response.showHide;
                        if (showHide) {
                            Object.keys(showHide).forEach(function (key) {
                                const showValue = showHide[key];
                                if (showValue == 0) {
                                    $('#show_' + key).hide();
                                    $('#pills-' + key).hide();
                                }
                                // $('#count_' + key).html(showValue);
                            });
                        }

                        if (result) {
                            $("#searchTab").show();
                        } else {
                            $("#searchTab").hide();
                            $("#noData-error").show();
                        }
                        // remove 'active' and 'show' classes
                        $("#pills-tab .nav-link").removeClass("active");
                        $("#pills-tabContent .tab-pane").removeClass("show", "active");
                        // Add 'active' and 'show' classes to the first tab and tab pane
                        const firstTab = document.querySelector("#pills-tab .nav-link");
                        const firstTabPane = document.querySelector("#pills-tabContent .tab-pane");
                        if (firstTab && firstTabPane) {
                            firstTab.classList.add("active");
                            firstTab.setAttribute("aria-selected", "true");
                            firstTabPane.classList.add("show", "active");
                        }
                    } else {
                        $("#searchTab").hide();
                        $("#noData-error").show();
                    }
                },
                error: function (xhr, status, error) {
                    console.log("in error function");
                }
            });
        }
    });
});

$(document).on('click', '.remove-text', function () {
    $('input[name="search"]').val('');
    $("#searchTab, #noData-error").hide();
    $('.otherResult .topResult').html('');
    $(this).hide();
    $("#search-result").show();
});