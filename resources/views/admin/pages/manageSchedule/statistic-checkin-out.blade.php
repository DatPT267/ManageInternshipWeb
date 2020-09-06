@extends('admin.layout.index')
@section('content')
    <h1 id="title">Thống kê lịch sử checkin-checkout tháng {{\Carbon\Carbon::now()->isoFormat('M')}}</h1>
    <button class="btn btn-light btn-icon-split" id="btn-before" data-url="{{route('ajax.statistical')}}">
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </span>
    </button>
    <input type="text" id="month" value="" style="width: 3rem; text-align: center" data-url="{{route('ajax.statistical')}}" disabled>
    <button class="btn btn-light btn-icon-split" id="btn-after" data-url="{{route('ajax.statistical')}}" disabled>
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-right"></i>
        </span>
    </button>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Thông tin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checks as $index => $check)
                <tr>
                    <td>{{$index}}</td>
                    <td>{{$check->user->name}}</td>
                    <td>
                        <a href="{{route('view-history-check', [$check->user_id, \Carbon\Carbon::now()->isoFormat('M')])}}" class="btn btn-info btn-circle">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var now = new Date();
            var date = now.getMonth()+1;
            $('#month').val(date);

            //===================================AJAX============================
            function callAjax(url, date){
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {date: date},
                    success: function (response) {
                        console.log(response);
                        var output = "";
                        if(response.data.length !== 0){
                            for (let i = 0; i < response.data.length; i++) {
                                output += "<tr>"+
                                    "<td>"+i+"</td>"+
                                    "<td>"+response.data[i].name+"</td>"+
                                    "<td><a href='student/"+response.data[i].user_id+"/view-history-schedule/month="+date+"' class='btn btn-info btn-circle'><i class='fas fa-info-circle'></i></a></td>"
                                +"</tr>";
                            }
                        } else{
                            output = "<tr><th colspan='3' style='text-align: center'>Không có ai thực tập</th></tr>"
                        }
                        $('tbody').html(output);
                    }
                });
            }
            //===================================AJAX============================
            $('#btn-before').click(function (){
                if($('input#month').val() > 1){
                    $('input#month').val( $('input#month').val() - 1);
                    date = $('input#month').val();
                    var url = $('#month').attr('data-url');
                    $('h1#title').text('Thống kê lịch sử checkin-checkout tháng ' +date);
                    callAjax(url, date);
                    $('#btn-after').attr('disabled', false);
                }
                if($('input#month').val() == 1){
                    $('#btn-before').attr('disabled', true);
                }
            })

            $('#btn-after').click(function (){
                var today = new Date();
                var month = today.getMonth() + 1;
                $('#btn-before').attr('disabled', false);
                if($('input#month').val() < month){
                    $('input#month').val(parseInt($('input#month').val()) + 1);
                    date = $('input#month').val();
                    var url = $('#month').attr('data-url');
                    $('h1#title').text('Thống kê lịch sử checkin-checkout tháng ' +date);
                    callAjax(url, date);
                }
                if($('input#month').val() == month){
                    $('#btn-after').attr('disabled', true);
                }
            })
        })
    </script>
@endsection
