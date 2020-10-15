@extends('admin.layout.index')
@section('content')
    <h1 id="title">Danh sách đăng ký thực tập trong tháng {{\Carbon\Carbon::now()->month}}</h1>
    <button class="btn btn-light btn-icon-split" id="btn-before" >
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </span>
    </button>
    Tháng <input type="text" id="month"
                            style="text-align: center; width: 3rem"
                            value="{{\Carbon\Carbon::now()->month}}"
                            data-url="{{route('ajax.view.schedule')}}"
                            disabled>
    <button class="btn btn-light btn-icon-split" id="btn-after" disabled>
        <span class="icon text-gray-600">
            <i class="fas fa-arrow-right"></i>
        </span>
    </button>
    <table class="table table-hover table-bordered" id="list-student">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $index => $schedule)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$schedule->user->name}}</td>
                    <td>
                        <a href="{{route('view-schedule', [$schedule->user_id, $month])}}" class="btn btn-info btn-circle" >
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
        $(document).ready(function (){
            $('#list-student').dataTable({
                'info': false,
                'order' : false,
                'paging': false,
                "bLengthChange": false,
                "searching": false,
                "language": {
                    "emptyTable": "Tháng này không có ai đăng ký thực tập"
                }
            });
            var date = 0;

            //=========================AJAX=============================
            function ajax(url, date){
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {date: date},
                    success: function (response) {
                        console.log(response);
                        var output = '';
                        if(response.data.length != 0){
                            for (let i = 0; i < response.data.length; i++) {
                                output += "<tr>"+
                                    "<td>"+response.data[i].id+"</td>"+
                                    "<td>"+response.data[i].name+"</td>"+
                                    "<td><a href='admin/student/"+response.data[i].user_id+"/view-schedule/month="+date+"' class='btn btn-info btn-circle'><i class='fas fa-info-circle'></i> </a></td>"
                                +"</tr>"
                            }

                        }else{
                            output = "<tr><th colspan='3' style='text-align: center'>Tháng này không có ai đăng ký thực tập</th></tr>"
                        }
                        $('tbody').html(output);
                    }
                });
            }
            //=========================AJAX=============================
            $('#btn-before').click(function (){
                $('#btn-after').attr('disabled', false);
                if( $('#month').val() > 1 ){
                    $('#month').val( $('#month').val() - 1);
                    date = $('#month').val();
                    var url = $('#month').attr('data-url');
                    // console.log(date);
                    $('h1#title').text("Danh sách đăng ký thực tập trong tháng "+date);
                    ajax(url, date);
                }
                if($('#month').val() == 1){
                    $('#btn-before').attr('disabled', true);
                    // alert('Tháng phải lớn hơn 0!');
                }
            })
            $('#btn-after').click(function (){
                var today = new Date();
                var month = today.getMonth() + 1;
                $('#btn-before').attr('disabled', false);
                if( $('#month').val() < month){
                    $('#month').val( parseInt($('#month').val()) + 1);
                    date = $('#month').val();
                    var url = $('#month').attr('data-url');
                    // console.log(date);
                    $('h1#title').text("Danh sách đăng ký thực tập trong tháng "+date);
                    ajax(url, date);
                }
                if($('#month').val() == month){
                    $('#btn-after').attr('disabled', true);
                }
            })
        })
    </script>
@endsection
