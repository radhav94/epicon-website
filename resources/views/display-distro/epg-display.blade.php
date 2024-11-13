<style>
    table, td {
        border: 0.5px solid whitesmoke;
        border-collapse: collapse;
    }
    .img-poster{
        width: 100%;
        height: 300px;
    }
    .para-info p, .para-info h5 {
    color: #fff;
    }
</style>
<div><img class="img-poster" src="{{$img_poster}}" alt="logo"></div>
<div class='my-3'><img class="distro-logo" src="https://epicon.in/img/distro_logo-white.png" alt="logo"></div>
<h5 class="para-info"><p>{{@$data['tv']['channel']['display-name']}}</p></h5>
<div class="para-info">
    <p>
        {{@$description}}
    </p>
</div>
<table class="para-info">
    @foreach ($programmes as $program)
        <tr>
            <td style="width:20%;">
                <p>{{@$program['now'] ? 'Now' : @$program['time_start']}}</p>
            </td>
            <td style="width:80%;">
                <h5>{{@$program['title']['_']}}</h5>
                <p>{{@$program['desc']['_']}}</p>
            </td>
        </tr>
    @endforeach
</table>