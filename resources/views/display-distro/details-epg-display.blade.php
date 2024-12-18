<style>
    table, td {
        border: 0.5px solid whitesmoke;
        border-collapse: collapse;
    }
    .schedule-table{
        width: 100%;
    }
</style>
<table class="para-info schedule-table">
    @foreach ($programmes as $program)
        <tr>
            <td style="width:20%;">
                <p>{{@$program['now'] ? 'Now' : @$program['time_start']}}</p>
            </td>
            <td style="width:80%;">
                <h4>{!!@$program['title'] !!}</h4>
                <p>{!!@$program['desc']!!}</p>
            </td>
        </tr>
    @endforeach
</table>