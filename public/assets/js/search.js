
$(document).ready(function(){
    $('.Alltopresult-error').hide();
    $('.Moviestopresult-error').hide();
    $('.Showtopresult-error').hide();
    $('.Podcasttopresult-error').hide();
    $('.Kidstopresult-error').hide();
    $('.Gamestopresult-error').hide();
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
            var searchText = $('#searchname').val();

            $('#Alltopresult').html(response.AlltopResult);
            $('#Moviestopresult').html(response.MoviestopResult);
            $('#Showtopresult').html(response.ShowstopResult);
            $('#Podcasttopresult').html(response.PodcaststopResult);
            $('#Kidstopresult').html(response.KidstopResult);
            $('#Gamestopresult').html(response.GamestopResult);
            
        if(searchText.length > 2){
            if(response.AlltopResult != ''){
                $('.Alltopresult-error').hide();
            }else{
                $('.Alltopresult-error').show();
            }
            if(response.MoviestopResult != ''){
                $('.Moviestopresult-error').hide();
            }else{
                $('.Moviestopresult-error').show();
            }
            if(response.ShowstopResult != ''){
                $('.Showtopresult-error').hide();
            }else{
                $('.Showtopresult-error').show();
            }
            if(response.PodcaststopResult != ''){
                $('.Podcasttopresult-error').hide();
            }else{
                $('.Podcasttopresult-error').show();
            }
            if(response.KidstopResult != ''){
                $('.Kidstopresult-error').hide();
            }else{
                $('.Kidstopresult-error').show();
            }
            if(response.GamestopResult != ''){
                $('.Gamestopresult-error').hide();
            }else{
                $('.Gamestopresult-error').show();
            }
        }else{
            $('.Alltopresult-error').hide();
            $('.Moviestopresult-error').hide();
            $('.Showtopresult-error').hide();
            $('.Podcasttopresult-error').hide();
            $('.Kidstopresult-error').hide();
            $('.Gamestopresult-error').hide();
        }
            
            
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