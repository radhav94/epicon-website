
$(document).ready(function(){

});

$("#searchname").on("keyup", function () {
    var searchtext = $('input[name="search"]').val();
    console.log(searchtext + "Text Value");
    $.ajax({
        url: '/search',
        type: 'POST',
        data: {'searchinput': searchtext},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);
            $('#Alltopresult').html(response.AlltopResult);
            $('#Moviestopresult').html(response.MoviestopResult);
            $('#Showtopresult').html(response.ShowstopResult);
            $('#Podcasttopresult').html(response.PodcaststopResult);
            $('#Kidstopresult').html(response.KidstopResult);
            $('#Gamestopresult').html(response.GamestopResult);
        },
        error: function(xhr, status, error) {
            console.log("in error function");
        }
    });
});

$(document).on('click', '.remove-text', function () {
    $('input[name="search"]').val('');
    $('#Alltopresult').html('');
    $('#Moviestopresult').html('');
    $('#Showtopresult').html('');
    $('#Podcasttopresult').html('');
    $('#Kidstopresult').html('');
    $('#Gamestopresult').html('');
});